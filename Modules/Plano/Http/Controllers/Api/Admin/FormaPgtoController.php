<?php

namespace Modules\Plano\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Plano\Criteria\FormaPgtoCriteria;
use Modules\Plano\Repositories\LancamentoRepository;
use Modules\Plano\Repositories\PlanoContratacaoRepository;
use Modules\Plano\Services\PagSeguroService;
use Modules\Plano\Theads\PagSeguroSessionIdThead;
use Portal\Http\Controllers\BaseController;
use Modules\Plano\Repositories\FormaPagamentoRepository;
use Portal\Services\CacheService;
use Prettus\Repository\Exceptions\RepositoryException;

class FormaPgtoController extends BaseController
{
    private $formaPagamentoRepository;
    /**
     * @var PagSeguroService
     */
    private $pagSeguroService;
    /**
     * @var CacheService
     */
    private $cacheService;

    public function __construct(
        FormaPagamentoRepository $formaPagamentoRepository,
        PagSeguroService $pagSeguroService,
        CacheService $cacheService
    )
    {
        $this->formaPagamentoRepository = $formaPagamentoRepository;
        parent::__construct($formaPagamentoRepository, FormaPgtoCriteria::class);
        $this->pagSeguroService = $pagSeguroService;
        $this->cacheService = $cacheService;
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = [
            'nome' => [
                'required',
                "unique:forma_pagamentos,nome" . (is_null($id) ? '' : ",$id"),
            ],
            'taxa' => [
                'required',
                'numeric'
            ],
            'status' => [
                'required',
                'boolean'
            ],
        ];
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
    public function store(Request $request){
        $data = $request->all();
        \Validator::make($data, $this->getValidator())->validate();
        try{
            $data['slug'] = str_slug($data['nome']);
            return $this->formaPagamentoRepository->create($data);
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

    public function formPgtoAtiva()
    {
        return $this->formaPagamentoRepository->formasAtivas();
    }

    public function getSessionId()
    {
        try {
            $userId = $this->getUserId();
            $cachename = 'session_pagseguro_' . $userId;
            $this->cacheService->forget($cachename);
            if ($this->cacheService->has($cachename)) {
                return $this->cacheService->get($cachename);
            }
            $session = $this->pagSeguroService->getSessionId();
            $this->cacheService->put($cachename, $session, 5);
            return $session;
        } catch (\Exception $e) {
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    public function pagamento(Request $request)
    {
        $data = $request->all();
        \Validator::make($data, [
            'code_contratacao' => 'required|exists:plano_contratacaos,id',
            'forma_pagamento' => 'required|exists:forma_pagamentos,slug',
            'method' => 'required',
            'hash' => 'required_if:method,CREDIT_CARD',
            'token' => 'required_if:method,CREDIT_CARD',
        ])->validate();
        $pagamento = $this->pagSeguroService->pagamentoByMethod($data);
        if($pagamento['success']){
            return $pagamento;
        }
        return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $pagamento['message']);
    }

}
