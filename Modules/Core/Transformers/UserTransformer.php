<?php

namespace Modules\Core\Transformers;

use Modules\Core\Models\Pessoa;
use Modules\Core\Models\User;
use Modules\Localidade\Transformers\EnderecoTransformer;
use Modules\Localidade\Transformers\TelefoneTransformer;
use Modules\Transporte\Transformers\DocumentoTransformer;
use Portal\Transformers\BaseTransformer;

/**
 * Class UserTransformer
 * @package namespace Modules\Core\Transformers;
 */
class UserTransformer extends BaseTransformer
{
    public $availableIncludes = ['permissions', 'roles', 'documentos'];
    public $defaultIncludes = [ 'endereco','pessoa', 'telefones'];

    /**
     * Transform the \User entity
     * @param \User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => (int)$model->id,
            'name' => (string)$model->name,
            'email' => (string)$model->email,
            'email_alternativo' => (string)$model->email_alternativo,
            'disponivel' => (boolean)$model->disponivel,
            'pagina_user' => (string)$model->pagina_user,
            'cep' => $model->cep,
            'documentos_validate' => (boolean) $model->documentos_validate,
            'imagem' => (string) \URL::to('/').($model->imagem) ? url('/arquivos/img/user/' . $model->imagem) : null,
            'status' => (string)$model->status,
            'ddd' => (is_null($model->telefone))?null:$model->telefone->ddd,
            'numero' => (is_null($model->telefone))?null:$model->telefone->numero,
            'chk_newsletter' => (boolean)$model->chk_newsletter,
            'device_uuid' => (string)$model->device_uuid,
            'excluido' => (boolean)$model->trashed(),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
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

    public function includePessoa(User $model)
    {
        if (!$model->pessoa) {
            return null;
        }
        return $this->item($model->pessoa, new PessoaTransformer());
    }

    public function includeDocumentos(User $model){
        if($model->documentos->count() == 0){
            return $this->null();
        }
        return $this->collection($model->documentos, new DocumentoTransformer());
    }

}
