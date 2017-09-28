<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Localidade\Services\GeoService;
use Modules\Transporte\Criteria\ChamadaCriteria;
use Modules\Transporte\Http\Requests\ChamadaRequest;
use Modules\Transporte\Repositories\ChamadaRepository;
use Modules\Transporte\Repositories\GeoPosicaoRepository;
use Portal\Http\Controllers\BaseController;

use Modules\Transporte\Models\Chamada;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Usuários no portal qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class ChamadaController extends BaseController
{
    /**
     * @var ChamadaRepository
     */
    private $chamadaRepository;
    /**
     * @var GeoService
     */
    private $geoService;
    /**
     * @var GeoPosicaoRepository
     */
    private $geoPosicaoRepository;

    public function __construct(
        ChamadaRepository $chamadaRepository,
        GeoService $geoService,
        GeoPosicaoRepository $geoPosicaoRepository)
    {
        parent::__construct($chamadaRepository, ChamadaCriteria::class);
        $this->chamadaRepository = $chamadaRepository;
        $this->geoService = $geoService;
        $this->geoPosicaoRepository = $geoPosicaoRepository;
    }


    public function getValidator($id = null)
    {
        $this->validator = (new ChamadaRequest())->rules($id);
        return $this->validator;
    }

    function listarCliente()
    {
        //todo listar chamas realizadas pelo cliente
    }

    function listarFornecedor()
    {
        //todo listar chamas realizadas pelo cliente
    }

    /**8
     * Iniciar a chamada
     *
     *
     * Endpoint para dar inicio ao serviço de chamada de taxi
     * @return mixed
     */
    function iniciarChamada(Request $request)
    {
        $data = $request->only(['origem', 'destino', 'forma_pagamento_id', 'endereco_origem', 'endereco_destino']);

        \Validator::make($data, [
            'endereco_origem' => 'required|string',
            'endereco_destino' => 'required|string',
            'origem' => 'required|array',
            'destino' => 'required|array',
            'forma_pagamento_id' => 'required|integer',
        ])->validate();
        $data['cliente_id'] = $this->getUserId();
        $data['tipo'] = Chamada::TIPO_SOLICITACAO;
        $data['status'] = Chamada::STATUS_PENDENTE;
        $data['timedown'] = Carbon::now()->addMinute(5);
        $data['valor'] = $this->geoService->distanceCalculate($data['origem'], $data['destino']);
        try {
            \DB::beginTransaction();
            $chamada = $this->chamadaRepository->create($data);
            $this->geoPosicaoRepository->create([
                'user_id' => $data['cliente_id'],
                'endereco' => $data['endereco_origem'],
                'transporte_geo_posicaotable_id' => $chamada['data']['id'],
                'transporte_geo_posicaotable_type' => Chamada::class,
                'lat' => $data['origem']['lat'],
                'lng' => $data['origem']['lng'],
                'passageiro' => false
            ]);
            $this->geoPosicaoRepository->create([
                'user_id' => $data['cliente_id'],
                'endereco' => $data['endereco_destino'],
                'transporte_geo_posicaotable_id' => $chamada['data']['id'],
                'transporte_geo_posicaotable_type' => Chamada::class,
                'lat' => $data['destino']['lat'],
                'lng' => $data['destino']['lng'],
                'passageiro' => false
            ]);
            //$chamada->geoPosition()
            \DB::commit();
            return $chamada;
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            \DB::rollback();
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            \DB::rollback();
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    function visualizar($idChamada)
    {
        $data = ['chamada_id' => $idChamada];
        \Validator::make($data, ['chamada_id' => '']);
        try {
            $chamada = $this->chamadaRepository->find($data['chamada_id']);
            if (is_null($chamada['data'])) {
                throw new \Exception('chamada invalida');
            }
            if (!($chamada['data']['cliente_id'] == $this->getUserId())) {
                throw new \Exception('chamada não pertence a você');
            }
            return $chamada;
        } catch (ModelNotFoundException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    function atender(Request $request, $idChamada)
    {
        $data = $request->only(['origem', 'destino', 'forma_pagamento_id', 'endereco_origem', 'endereco_destino']);
        $chamada = $this->chamadaRepository->find($idChamada);
        if(empty($chamada['data'])){
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, 'Chamada inválida');
        }
        if($chamada['data']['tipo'] ==  Chamada::TIPO_ATENDIMENTO){
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, 'Está chamada já está em atendimento.');
        }
        \Validator::make($data, [
            'endereco_origem' => 'required|string',
            'origem' => 'required|array',
        ])->validate();
        $data['fornecedor_id'] = $this->getUserId();
        $data['tipo'] = Chamada::TIPO_ATENDIMENTO;
        $data['valor'] = $this->geoService->distanceCalculate($data['origem'], $data['destino']);
        try {
            \DB::beginTransaction();
            $chamada = $this->chamadaRepository->update($data, $idChamada);
            $this->geoPosicaoRepository->create([
                'user_id' => $data['cliente_id'],
                'endereco' => $data['endereco_origem'],
                'transporte_geo_posicaotable_id' => $idChamada,
                'transporte_geo_posicaotable_type' => Chamada::class,
                'lat' => $data['origem']['lat'],
                'lng' => $data['origem']['lng'],
                'passageiro' => false
            ]);
            //$chamada->geoPosition()
            \DB::commit();
            return $chamada;
        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            \DB::rollback();
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            \DB::rollback();
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    function cancelar($idChamada)
    {
        $data = ['chamada_id' => $idChamada];
        \Validator::make($data, ['chamada_id' => 'required']);
        try {
            $chamada = $this->chamadaRepository->find($data['chamada_id']);
            if (is_null($chamada['data'])) {
                throw new \Exception('chamada invalida');
            }
            if (!($chamada['data']['cliente_id'] == $this->getUserId())) {
                throw new \Exception('chamada não pertence a você');
            }
            $chamada['status'] = Chamada::STATUS_CANCELADO;
            $this->chamadaRepository->update($chamada, $idChamada);
            return $chamada;
        } catch (ModelNotFoundException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    function calcularRota(Request $request)
    {
        $data = $request->only(['origem', 'destino']);
        \Validator::make($data, [
            'origem' => 'required|array',
            'destino' => 'required|array',
        ])->validate();
        return ['data' => ['valor' => $this->geoService->distanceCalculate($data['origem'], $data['destino'])]];
    }


}
