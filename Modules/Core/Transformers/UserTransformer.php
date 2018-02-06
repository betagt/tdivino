<?php

namespace Modules\Core\Transformers;

use Modules\Core\Models\Pessoa;
use Modules\Core\Models\User;
use Modules\Localidade\Transformers\EnderecoTransformer;
use Modules\Localidade\Transformers\TelefoneTransformer;
use Modules\Transporte\Models\Chamada;
use Modules\Transporte\Models\Veiculo;
use Modules\Transporte\Transformers\ContaTransformer;
use Modules\Transporte\Transformers\DocumentoTransformer;
use Modules\Transporte\Transformers\VeiculoTransformer;
use Portal\Transformers\BaseTransformer;

/**
 * Class UserTransformer
 * @package namespace Modules\Core\Transformers;
 */
class UserTransformer extends BaseTransformer
{
	public $availableIncludes = ['permissions', 'roles', 'documentos'];
	public $defaultIncludes = ['endereco', 'telefones', 'pessoa', 'contas', 'veiculo_ativo'];

	/**
	 * Transform the \User entity
	 * @param \User $model
	 *
	 * @return array
	 */
	public function transform(User $model)
	{
		$perfil = current($model->getRoles());
		$result = [
			'id' => (int)$model->id,
			'name' => (string)$model->name,
			'name_flag' => (string)$model->name . " - $perfil",
			'email' => (string)$model->email,
			'email_alternativo' => (string)$model->email_alternativo,
			'disponivel' => (boolean)$model->disponivel,
			'pagina_user' => (string)$model->pagina_user,
			'cep' => $model->cep,
			'perfil' => $perfil,
			'documentos_validate' => (boolean)$model->documentos_validate,
			'imagem' => (string)\URL::to('/') . ($model->imagem) ? url('/arquivos/img/user/' . $model->imagem) : null,
			'status' => (string)$model->status,
			'ddd' => (is_null($model->telefone)) ? null : $model->telefone->ddd,
			'numero' => (is_null($model->telefone)) ? null : $model->telefone->numero,
			'chk_newsletter' => (boolean)$model->chk_newsletter,
			'device_uuid' => (string)$model->device_uuid,
			'indicacao' => (string)$model->indicacao,
			'codigo' => (string)$model->codigo,
			'aceita_termos' => (boolean)$model->aceita_termos,
			'excluido' => (boolean)$model->trashed(),
			'created_at' => $model->created_at,
			'updated_at' => $model->updated_at,
		];
		switch ($perfil) {
			case User::FORNECEDOR :
				$soma = $model->chamadas_fornecedor->where('tipo', Chamada::TIPO_FINALIZADO)->sum('avaliacao');
				$avaliacao = 0;
				if ($soma > 0) {
					$avaliacao = $soma / $model->chamadas_fornecedor->where('tipo', Chamada::TIPO_FINALIZADO)->count('avaliacao');
				}
				$result = array_merge($result, [
					'nota_fornecedor' => $avaliacao,
					'contagem_chamadas' => $model->chamadas_fornecedor->count(),
					'km_mes_rodado' => $model->chamadas_fornecedor->sum('km_rodado'),
                    'habilitado' => $model->habilitado
				]);
				if (!is_null($model->veiculoAtivo)) {

					$clrv = $model->veiculoAtivo->clrvAtivo;
					$vistoria = $model->veiculoAtivo->vistoriaAtivo;
					$seguro = $model->veiculoAtivo->seguroAtivo;
					$result = array_merge($result, [
						'veiculo_marca' => $model->veiculoAtivo->marca->nome,
						'veiculo_placa' => $model->veiculoAtivo->placa,
						'veiculo_cor' => $model->veiculoAtivo->cor,
						'ano_modelo_fab' => $model->veiculoAtivo->ano_modelo_fab,
						'renavam' => $model->veiculoAtivo->renavam,
						'chassi' => $model->veiculoAtivo->chassi,
						'veiculo_status' => $model->veiculoAtivo->status,
						'veiculo_modelo' => $model->veiculoAtivo->modelo->nome
					]);
					if ($clrv) {
						$result = array_merge($result, [
							'veiculo_clrv_vencimento' => ($clrv) ? $clrv->data_vigencia_fim : null,
						]);
					}
					if ($vistoria) {
						$result = array_merge($result, [
							'veiculo_vistoria_data_emissao' => ($vistoria) ? $vistoria->data_emissao: null,
						]);
					}
					if ($seguro) {
						$result = array_merge($result, [
							'veiculo_seguro_numero' => ($seguro) ? $seguro->numero : null,
							'veiculo_seguro_vencimento' => ($seguro) ? $seguro->data_vigencia_fim : null,
						]);
					}
				}
				break;
		};
		return $result;
	}

	public function includePermissions(User $model)
	{
		if (!$model->permissions) {
			return null;
		}
		return $this->collection($model->permissions, new PermissionTransformer());
	}

	public function includeRoles(User $model)
	{
		if (!$model->return_roles) {
			return null;
		}
		return $this->collection($model->return_roles, new RoleTransformer());
	}

	public function includeTelefones(User $model)
	{
		if (!$model->telefones) {
			return null;
		}
		return $this->collection($model->telefones, new TelefoneTransformer());
	}

	public function includeEndereco(User $model)
	{
		if (!$model->endereco) {
			return null;
		}
		return $this->item($model->endereco, new EnderecoTransformer());
	}

	public function includeVeiculoAtivo(User $model)
	{
		if (!$model->veiculoAtivo) {
			return null;
		}
		return $this->item($model->veiculoAtivo, new VeiculoTransformer());
	}

	public function includePessoa(User $model)
	{
		if (!$model->pessoa) {
			return null;
		}
		return $this->item($model->pessoa, new PessoaTransformer());
	}

	public function includeDocumentos(User $model)
	{
		if ($model->documentos->count() == 0) {
			return $this->null();
		}
		return $this->collection($model->documentos, new DocumentoTransformer());
	}

	public function includeContas(User $model)
	{
		if ($model->contas->count() == 0) {
			return $this->null();
		}
		return $this->collection($model->contas, new ContaTransformer());
	}

}
