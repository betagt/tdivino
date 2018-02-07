<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Core\Services\ImageUploadService;
use Modules\Transporte\Criteria\DocumentoCriteria;
use Modules\Transporte\Http\Requests\DocumentoRequest;
use Modules\Transporte\Repositories\DocumentoRepository;
use Modules\Transporte\Repositories\ServicoRepository;
use Modules\Transporte\Repositories\TipoDocumentoRepository;
use Portal\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Usuários no portal qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class DocumentoController extends BaseController
{

    /**
     * @var DocumentoRepository
     */
    private $documentoRepository;
    /**
     * @var ImageUploadService
     */
    private $imageUploadService;
    /**
     * @var TipoDocumentoRepository
     */
    private $tipoDocumentoRepository;
    /**
     * @var ServicoRepository
     */
    private $servicoRepository;

    public function __construct(
        DocumentoRepository $documentoRepository,
        TipoDocumentoRepository $tipoDocumentoRepository,
        ServicoRepository $servicoRepository,
        ImageUploadService $imageUploadService)
    {
        parent::__construct($documentoRepository, DocumentoCriteria::class);
        $this->documentoRepository = $documentoRepository;
        $this->setPathFile(public_path('arquivos/img/documento'));
        $this->imageUploadService = $imageUploadService;
        $this->tipoDocumentoRepository = $tipoDocumentoRepository;
        $this->servicoRepository = $servicoRepository;
    }


    public function getValidator($id = null)
    {
        $this->validator = (new DocumentoRequest())->rules($id);
        return $this->validator;
    }

    /**
     * Cadastrar
     *
     * Endpoint para cadastrar
     *
     * @param Request $request
     * @return retorna um registro criado
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'arquivo', 'transporte_tipo_documento_id', 'user_id'
        ]);
        \Validator::make($data, [
            'arquivo' => 'required|array',
            'user_id' => 'exists:users,id|array',
            'transporte_tipo_documento_id|array' => 'required'
        ])->validate();
        try {
            foreach ($data['arquivo'] as $key =>$val){
                $this->imageUploadService->upload64('arquivo', $this->getPathFile(), $data);
                $data['status'] = 'pendente';
                $arquivo = $this->documentoRepository->skipPresenter(true)->findWhere(['user_id' => $data['user_id'], 'transporte_tipo_documento_id' => $data['transporte_tipo_documento_id']]);
                if ($arquivo->count() > 0) {
                    foreach ($arquivo->all() as $item) {
                        $item->delete();
                    }
                }
            }
            return $this->documentoRepository->create($data);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function meusdocumentos()
    {
        try {
            //TODO melhorar este processo para poder validar quando o usuário se contem todos os documentos aceitos.
            $servico = $this->servicoRepository->first();
            $validacao = [];
            foreach ($servico['data']['habilidades_values'] as $key => $item) {
                $arquivo = $this->documentoRepository->skipPresenter(true)->findWhere(['user_id' => $this->getUser()->id, 'transporte_tipo_documento_id' => $item]);
                $status = ($arquivo->count() > 0) ? $arquivo->first()->status : null;
                $validacao[] = [
                    'id' => $item,
                    'label' => $servico['data']['habilidades_labels'][$key],
                    'ativo' => ($status == 'aceito'),
                    'status_label' => ($status == 'aceito') ? 'Aceito' : 'Requerido'
                ];
            }
            $retorno = $this->documentoRepository->skipPresenter(false)->findByField('user_id', $this->getUser()->id);
            $retorno['validacao'] = $validacao;
            return $retorno;
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage() . ' Linha: ' . $e->getLine()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage() . ' Linha: ' . $e->getLine()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage() . ' Linha: ' . $e->getLine()]));
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
    public function storeByUser(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->getUserId();
        \Validator::make($data, [
            'arquivo' => 'required',
            'transporte_tipo_documento_id' => 'required'
        ])->validate();
        try {
            $this->imageUploadService->upload64('arquivo', $this->getPathFile(), $data);
            $data['status'] = 'pendente';
            $arquivo = $this->documentoRepository->skipPresenter(true)->findWhere(['user_id' => $data['user_id'], 'transporte_tipo_documento_id' => $data['transporte_tipo_documento_id']]);
            if ($arquivo->count() > 0) {
                foreach ($arquivo->all() as $item) {
                    $item->delete();
                }
            }
            return $this->documentoRepository->create($data);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function aceitar($id)
    {
        try {
            $documento = $this->documentoRepository->skipPresenter(true)->find($id);
            $documento->status = 'aceito';
            $documento->save();
            return parent::responseSuccess(parent::HTTP_CODE_OK, 'Documento aceito!');
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function recusar($id)
    {
        try {
            $documento = $this->documentoRepository->skipPresenter(true)->find($id);
            $documento->status = 'invalido';
            $documento->save();
            return parent::responseSuccess(parent::HTTP_CODE_OK, 'Documento inválido!');
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function arquivo(Request $request, $id)
    {
        $data = $request->only(['arquivo']);

        \Validator::make($data, [
            'arquivo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,bmp,png'
            ]
        ])->validate();
        try {
            $this->imageUploadService->upload('arquivo', $this->getPathFile(), $data);
            return $this->documentoRepository->update($data, $id);
        } catch (ModelNotFoundException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Deletar
     *
     * Endpoint para deletar passando o ID
     */
    public function excluir(Request $request){
        $data = $request->all();
        \Validator::make($data, [
            'ids'=>'array|required'
        ])->validate();

        try{
            \DB::beginTransaction();
            app($this->documentoRepository->model())->destroy($data['ids']);
            $result = self::responseSuccess(self::HTTP_CODE_OK, self::MSG_REGISTRO_EXCLUIDO);
            \DB::commit();
            return $result;
        }catch (ModelNotFoundException $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }catch (RepositoryException $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }catch (\Exception $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }
}
