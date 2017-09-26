<?php

namespace Modules\Plano\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Plano\Criteria\LancamentoCriteria;
use Modules\Plano\Criteria\PlanoContratacaoCriteria;
use Modules\Plano\Repositories\LancamentoRepository;
use Modules\Plano\Services\PlanoContratacaoService;
use Portal\Criteria\OrderCriteria;
use Portal\Http\Controllers\BaseController;
use Modules\Plano\Http\Requests\PlanoContratacaoRequest;
use Modules\Plano\Repositories\PlanoContratacaoRepository;
use Prettus\Repository\Exceptions\RepositoryException;

class PlanoContratacaoController extends BaseController
{
    /**
     * @var PlanoContratacaoRepository
     */
    private $planoContratacaoRepository;
    /**
     * @var PlanoContratacaoService
     */
    private $planoContratacaoService;
    /**
     * @var LancamentoRepository
     */
    private $lancamentoRepository;

    public function __construct(
        PlanoContratacaoRepository $planoContratacaoRepository,
        PlanoContratacaoService $planoContratacaoService,
        LancamentoRepository $lancamentoRepository)
    {
        parent::__construct($planoContratacaoRepository, PlanoContratacaoCriteria::class);
        $this->planoContratacaoRepository = $planoContratacaoRepository;
        $this->planoContratacaoService = $planoContratacaoService;
        $this->lancamentoRepository = $lancamentoRepository;
    }


    public function store(Request $request)
    {
        $data = $request->all();
        \Validator::make($data, $this->getValidator())->validate();
        try {
            return $this->planoContratacaoService->updateOrCreate($data);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        }
    }

    /**
     * Alterar
     *
     * Endpoint para alterar
     *
     * @param Request $request
     * @param $id
     * @return array retorna registro alterado
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        \Validator::make($data, $this->getValidator($id))->validate();
        try {
            return $this->planoContratacaoService->updateOrCreate($data, $id);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        }
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new PlanoContratacaoRequest())->rules();
        return $this->validator;
    }

    /**
     * Consultar
     *
     *
     * Endpoint para consultar todos os Anuncio cadastrados
     *
     * Nessa consulta pode ser aplicado os seguintes filtros:
     *
     *  - Consultar Normal:
     *   <br> - Não passar parametros
     *
     *  - Consultar por Cidade:
     *   <br> - ?consulta={"filtro": {"estados.uf": "TO", "cidades.titulo" : "Palmas"}}
     */
    public function indexLancamento($contratacao, Request $request)
    {
        $request->merge(['contratacao' => $contratacao]);

        try {
            return $this->lancamentoRepository
                ->pushCriteria(new LancamentoCriteria($request))
                ->pushCriteria(new OrderCriteria($request))
                ->paginate(self::$_PAGINATION_COUNT);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        }
    }

    public function enviarEmailContratacao(Request $request)
    {
        $data = $request->all();
        \Validator::make($data, [
            'email' => 'required|email'
        ])->validate();
    }
}