<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Core\Services\ImageUploadService;
use Modules\Transporte\Criteria\VeiculoCriteria;
use Modules\Transporte\Http\Requests\VeiculoRequest;
use Modules\Transporte\Models\Veiculo;
use Modules\Transporte\Repositories\VeiculoRepository;
use Modules\Transporte\Services\DocumentoService;
use Portal\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Usuários no portal qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class VeiculoController extends BaseController
{

    /**
     * @var VeiculoRepository
     */
    private $veiculoRepository;
    /**
     * @var ImageUploadService
     */
    private $imageUploadService;
    /**
     * @var DocumentoService
     */
    private $documentoService;

    public function __construct(
        VeiculoRepository $veiculoRepository,
        DocumentoService $documentoService,
        ImageUploadService $imageUploadService)
    {
        parent::__construct($veiculoRepository, VeiculoCriteria::class);
        $this->setPathFile(public_path('arquivos/img/documento'));
        $this->veiculoRepository = $veiculoRepository;
        $this->imageUploadService = $imageUploadService;
        $this->documentoService = $documentoService;
    }


    public function getValidator($id = null)
    {
        $this->validator = (new VeiculoRequest())->rules($id);
        return $this->validator;
    }

    public function veiculocadastro(Request $request){
        $data = $request->only([
            'transporte_marca_carro_id',
            'transporte_modelo_carro_id',
            'placa',
            'ano',
            'cor'
        ]);
        \Validator::extend('veiculo_user_exists', function ($attribute, $value, $parameters, $validator) use ($data) {
            $veiculos = $this->veiculoRepository->findWhere([
                'placa'=>$data['placa'],
            ]);
            return !(count($veiculos['dataa']) > 0);
        },'Veiculo já pertence a um usuário!');
        \Validator::make($data, [
            'transporte_marca_carro_id' =>'required|integer|exists:transporte_marca_carros,id',
            'transporte_modelo_carro_id' =>'required|integer|exists:transporte_modelo_carros,id',
            'ano' =>'required|integer',
            'placa' =>'required|string|veiculo_user_exists',
            'cor' =>'required|string'
        ])->validate();

        try{
            $this->imageUploadService->upload64('arquivo', $this->getPathFile(), $data);
            $data['status'] = 'pendente';
            $data['user_id'] = $this->getUserId();
            return $this->veiculoRepository->create($data);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    public function update(Request $request, $id)
    {
        $aux = [];
        $data = $request->only([
            'transporte_marca_carro_id',
            'transporte_modelo_carro_id',
            'placa',
            'ano',
            'ano_modelo_fab',
            'cor',
            'user_id',
            'arquivos',
			'renavam',
			'chassi',
            'status',
            'documentos'
        ]);
        /*\Validator::extend('veiculo_user_exists', function ($attribute, $value, $parameters, $validator) use ($data) {
            $veiculos = $this->veiculoRepository->findWhere([
                'placa'=>$data['placa'],
            ]);
            return !(count($veiculos['data']) > 0);
        },'Veiculo já pertence a um usuário!');*/
        \Validator::make($data, [
            'user_id'=>'required|integer|exists:users,id',
            'transporte_marca_carro_id' =>'required|integer|exists:transporte_marca_carros,id',
            'transporte_modelo_carro_id' =>'required|integer|exists:transporte_modelo_carros,id',
            'ano' =>'required|integer',
            'status' =>'required|in:pendente,aceito,invalido',
            'placa' =>'required|string',
            'cor' =>'required|string',
            'documentos' => 'array|nullable',
            'documentos.*.transporte_tipo_documento_id' => 'integer|nullable',
            'documentos.*.arquivos' => 'array|nullable',
        ])->validate();
            try{
                \DB::beginTransaction();
				if($data['status'] == Veiculo::ACEITO){
					Veiculo::where('user_id', $data['user_id'])
						->update([
							'status' => Veiculo::PENDENTE,
						]);
				}
                $veiculo = $this->veiculoRepository->skipPresenter(true)->update($data,$id);
                $documento = $veiculo->documento();
                foreach ($data['documentos'] as $doc){
                    $this->documentoService->cadastrarDocumento($doc, $documento,$this->getPathFile());
                }
                $result = $this->veiculoRepository->find($veiculo->id);
                \DB::commit();
                return $result;
            }catch (ModelNotFoundException $e){
                \DB::rollBack();
                return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
            }
            catch (RepositoryException $e){
                \DB::rollBack();
                return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
            }
            catch (\Exception $e){
                \DB::rollBack();
                return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
            }
    }

    /**
     * Cadastrar
     *
     * Endpoint para cadastrar
     *
     * @param Request $request
     * @return retorna um registro criado
     */
    public function store(Request $request){
        $aux = [];
        $data = $request->only([
            'transporte_marca_carro_id',
            'transporte_modelo_carro_id',
            'placa',
            'ano',
			'ano_modelo_fab',
            'cor',
            'renavan',
            'chassi',
            'user_id',
            'arquivos',
            'status',
            'documentos'
        ]);

        \Validator::extend('veiculo_user_exists', function ($attribute, $value, $parameters, $validator) use ($data) {
            $veiculos = $this->veiculoRepository->findWhere([
                'user_id'=>$data['user_id'],
                'placa'=>$data['placa'],
            ]);
            return !(count($veiculos['data']) > 0);
        },'Veiculo já pertence a um usuário!');
        \Validator::make($data, [
            'user_id'=>'required|integer|exists:users,id',
            'transporte_marca_carro_id' =>'required|integer|exists:transporte_marca_carros,id',
            'transporte_modelo_carro_id' =>'required|integer|exists:transporte_modelo_carros,id',
            'ano' =>'required|integer',
            'status' =>'required|in:pendente,aceito,invalido',
            'placa' =>'required|string|veiculo_user_exists',
            'cor' =>'required|string',
            'documentos' => 'array',
            'documentos.*.transporte_tipo_documento_id' => 'required|integer',
            'documentos.*.arquivos' => 'required|array',
        ])->validate();
        try{
            \DB::beginTransaction();if($data['status'] == Veiculo::ACEITO){
				Veiculo::where('user_id', $data['user_id'])
					->update([
						'status' => Veiculo::PENDENTE,
					]);
			}
            $veiculo = $this->veiculoRepository->skipPresenter(true)->create($data);
            foreach ($data['documentos'] as $doc){
                $this->documentoService->cadastrarDocumento($doc, $veiculo->documento(),$this->getPathFile());
            }
            $result = $this->veiculoRepository->find($veiculo->id);
            \DB::commit();
            return $result;
        }catch (ModelNotFoundException $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    function updateImageVeiculo(Request $request, $id){
        $data = $request->only([
            'arquivo',
        ]);

        \Validator::make($data, ['arquivo'=>'required'])->validate();

        try{
            $veiculo = $this->veiculoRepository->findWhere([
                'user_id'=>$this->getUserId(),
                'id'=>$id
            ]);
            if(count($veiculo['data']) == 0){
                throw new \Exception('esse veiculo não pertence a voce!');
            }
            $first = current($veiculo['data']);
            $this->imageUploadService->upload64('arquivo', $this->getPathFile(), $data);
            $first['status'] = 'pendente';
            $first['num_passageiro'] = (int) $first['num_passageiro'];
            $this->veiculoRepository->update($first, $id);
            return parent::responseSuccess(parent::HTTP_CODE_OK, 'Obrigado!, Foto enviada em breve analisaremos!');
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }

    }

    function todosByUser(){
        try{
            return $this->veiculoRepository->findWhere([
                'user_id'=>$this->getUserId()
            ]);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    function cores(){
        $path = module_path('Transporte');
        return ['data'=>csv_load($path.'/Files/Cores/veiculo-cor.csv')];
    }

}
