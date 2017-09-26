<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Transporte\Http\Requests\ServicoRequest;
use Modules\Transporte\Repositories\ServicoRepository;
use Modules\Transporte\Services\ServicoService;
use Portal\Criteria\OrderCriteria;
use Modules\Core\Criteria\RoleCriteria;
use Portal\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;
use Validator;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Usuários no portal qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class ServicoController extends BaseController
{

    /**
     * @var ServicoRepository
     */
    private $servicoRepository;

    /**
     * @var ServicoService
     */
    private $servicoService;

    public function __construct(
        ServicoRepository $servicoRepository,
        ServicoService $servicoService)
    {
        parent::__construct($servicoRepository, RoleCriteria::class);
        $this->servicoRepository = $servicoRepository;
        $this->servicoService = $servicoService;
    }


    public function getValidator($id = null)
    {
        $this->validator = (new ServicoRequest())->rules($id);
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
            'nome',
            'nome_similar',
            'tipo_documentos'
        ]);
        \Validator::make($data, $this->getValidator())->validate();
        try {
            return $this->servicoService->create($data);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    /**
     * Alterar
     *
     * Endpoint para alterar
     *
     * @param Request $request
     * @param $id
     * @return retorna registro alterado
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'nome',
            'nome_similar',
            'tipo_documentos'
        ]);
        \Validator::make($data, $this->getValidator($id))->validate();
        try {
            return $this->servicoService->update($data, $id);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    public function servicoAtivo(){
        try {
            return $this->servicoService->first();
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }
}
