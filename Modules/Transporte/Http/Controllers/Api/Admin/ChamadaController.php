<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Localidade\Services\GeoService;
use Modules\Transporte\Criteria\ChamadaCriteria;
use Modules\Transporte\Criteria\ChamadaFornecedorCriteria;
use Modules\Transporte\Events\ChamadaAceita;
use Modules\Transporte\Events\ChamadaMotoristaNoLocal;
use Modules\Transporte\Events\ChamarMotorista;
use Modules\Transporte\Events\FinalizarChamada;
use Modules\Transporte\Http\Requests\ChamadaRequest;
use Modules\Transporte\Notifications\IniciarChamadaNotify;
use Modules\Transporte\Repositories\ChamadaRepository;
use Modules\Transporte\Repositories\GeoPosicaoRepository;
use Portal\Criteria\OrderCriteria;
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

    function listarByFornecedor(Request $request)
    {
        try {
            $result = $this->chamadaRepository
                ->pushCriteria(new ChamadaFornecedorCriteria($request, $this->getUserId()))
                ->pushCriteria(new OrderCriteria($request))
                ->paginate(self::$_PAGINATION_COUNT);

            $result['meta']['financeiro']['total'] = $this->chamadaRepository->somaFornecedorTotais($this->getUserId());
            $result['meta']['financeiro']['mes'] = $this->chamadaRepository->somaFornecedorMes($this->getUserId());
            $result['meta']['financeiro']['semana'] = $this->chamadaRepository->somaFornecedorSemana($this->getUserId());
            $result['meta']['financeiro']['hoje'] = $this->chamadaRepository->somaFornecedorHoje($this->getUserId());
            return $result;
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
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
		//\Notification::send($this->getUser(), new IniciarChamadaNotify());
		/*$options = array(
			'cluster' => 'us2',
			'encrypted' => false
		);
		$pusher = new \Pusher(
			'432c193295441f1cd8bb',
			'e7c5d6602965d882a4c8',
			'429229',
			$options
		);

		$data['name'] = 'teste';
		$data['message'] = 'teste';
		dd($pusher->trigger('my-channel', 'my-event', $data));*/
		/*event(new ChamarMotorista($this->getUser(), "teste", $request->bearerToken()));
    	die;*/
        $data = $request->only(['origem', 'destino', 'endereco_origem', 'endereco_destino']);

        \Validator::make($data, [
            'endereco_origem' => 'required|string',
            'endereco_destino' => 'required|string',
            'origem' => 'required|array',
            'destino' => 'required|array'
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
                'transporte_geo_posicaotable_type_id' => $chamada['data']['id'],
                'transporte_geo_posicaotable_type_type' => Chamada::class,
                'lat' => $data['origem']['lat'],
                'lng' => $data['origem']['lng'],
                'passageiro' => false
            ]);
            $this->geoPosicaoRepository->create([
                'user_id' => $data['cliente_id'],
                'endereco' => $data['endereco_destino'],
                'transporte_geo_posicaotable_type_id' => $chamada['data']['id'],
                'transporte_geo_posicaotable_type_type' => Chamada::class,
                'lat' => $data['destino']['lat'],
                'lng' => $data['destino']['lng'],
                'passageiro' => false
            ]);
            \DB::commit();
            $chamada = $this->chamadaRepository->find($chamada['data']['id']);
            event(new ChamarMotorista($this->getUser()->device_uuid, $chamada));
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
        \Validator::make($data, ['chamada_id' => 'required|exists:transporte_chamadas,id']);
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

    function visualizarFornecedor($idChamada)
    {
        $data = ['chamada_id' => $idChamada];
        \Validator::make($data, ['chamada_id' => 'required|exists:transporte_chamadas,id']);
        try {
            $chamada = $this->chamadaRepository->find($data['chamada_id']);
            if (is_null($chamada['data'])) {
                throw new \Exception('chamada invalida');
            }
            if (!($chamada['data']['fornecedor_id'] == $this->getUserId())) {
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
        $data = $request->only(['origem', 'endereco_origem']);
        $data['chamada_id'] = $idChamada;
        \Validator::make($data, [
            'endereco_origem' => 'required|string',
            'origem' => 'required|array',
            'chamada_id'=>'required|exists:transporte_chamadas,id'
        ])->validate();
        $chamada = $this->chamadaRepository->find($idChamada);
        if (empty($chamada['data'])) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, 'Chamada inválida');
        }
        if ($chamada['data']['tipo'] == Chamada::TIPO_ATENDIMENTO) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, 'Está chamada já está em atendimento.');
        }
        \Validator::make($data, [
            'endereco_origem' => 'required|string',
            'origem' => 'required|array',
        ])->validate();
        $data['fornecedor_id'] = $this->getUserId();
        $data['datahora_comfirmação'] = Carbon::now();
        $data['tipo'] = Chamada::TIPO_ATENDIMENTO;
        $this->getUser()->disponivel = false;
        $this->getUser()->save();
        try {
            \DB::beginTransaction();
            $chamada = $this->chamadaRepository->skipPresenter(true)->update($data, $idChamada);
            $this->geoPosicaoRepository->create([
                'user_id' => $data['fornecedor_id'],
                'endereco' => $data['endereco_origem'],
                'transporte_geo_posicaotable_id' => $idChamada,
                'transporte_geo_posicaotable_type' => Chamada::class,
                'lat' => $data['origem']['lat'],
                'lng' => $data['origem']['lng'],
                'passageiro' => false
            ]);
            $response = $this->chamadaRepository->skipPresenter(false)->find($idChamada);
            event(new ChamadaAceita($chamada->cliente->device_uuid, $response));
            \DB::commit();
            return $response;
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
        \Validator::make($data, [
            'chamada_id'=>'required|exists:transporte_chamadas,id'
        ])->validate();
        try {
            \DB::beginTransaction();
            $chamada = $this->chamadaRepository->find($data['chamada_id']);
            if ($chamada['data']['status'] == Chamada::STATUS_CANCELADO) {
                throw new \Exception('chamada já cancelada');
            }
            if (is_null($chamada['data'])) {
                throw new \Exception('chamada invalida');
            }
            if (!($chamada['data']['cliente_id'] == $this->getUserId())) {
                throw new \Exception('chamada não pertence a você');
            }
            $chamada['status'] = Chamada::STATUS_CANCELADO;
            $chamada = $this->chamadaRepository->skipPresenter(true)->update($chamada, $idChamada);
            $response = $this->chamadaRepository->skipPresenter(false)->find($idChamada);
            event(new FinalizarChamada($chamada->fornecedor->device_uuid, $response));
            \DB::commit();
            return $response;
        } catch (ModelNotFoundException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    public function motoristaNoLocal($idChamada){
        $data = ['chamada_id' => $idChamada];
        \Validator::make($data, [
            'chamada_id'=>'required|exists:transporte_chamadas,id'
        ])->validate();
        try {
            $chamada = $this->chamadaRepository->skipPresenter(true)->find($data['chamada_id']);
            if ($chamada->status == Chamada::STATUS_CANCELADO) {
                throw new \Exception('chamada já cancelada');
            }
            if (is_null($chamada)) {
                throw new \Exception('chamada invalida');
            }
            if (!($chamada->cliente_id == $this->getUserId())) {
                throw new \Exception('chamada não pertence a você');
            }
            event(new ChamadaMotoristaNoLocal($chamada->fornecedor->device_uuid, "Motorista aguardando no local indicado!"));
        } catch (ModelNotFoundException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }

    }

    function cancelarForcedor($idChamada)
    {
        $data = ['chamada_id' => $idChamada];
        \Validator::make($data, ['chamada_id' => 'required']);
        try {
            $chamada = $this->chamadaRepository->find($data['chamada_id']);
            if ($chamada['data']['status'] == Chamada::STATUS_CANCELADO) {
                throw new \Exception('chamada já cancelada');
            }
            if (is_null($chamada['data'])) {
                throw new \Exception('chamada invalida');
            }
            if (!($chamada['data']['fornecedor_id'] == $this->getUserId())) {
                throw new \Exception('chamada não pertence a você');
            }
            $chamada['status'] = Chamada::STATUS_CANCELADO;
            $this->chamadaRepository->update($chamada, $idChamada);
            return $chamada;
        } catch (ModelNotFoundException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    function embarquePassageiro(Request $request, $idChamada){
        $data = ['chamada_id' => $idChamada];
        \Validator::make($data, [
            'chamada_id'=>'required|exists:transporte_chamadas,id'
        ])->validate();
        try {
            $chamada = $this->chamadaRepository->find($data['chamada_id']);

            if (is_null($chamada['data'])) {
                throw new \Exception('chamada invalida');
            }
            if (!($chamada['data']['fornecedor_id'] == $this->getUserId())) {
                throw new \Exception('chamada não pertence a você');
            }
            $chamada['data']['datahora_embarque'] = Carbon::now();
            return $this->chamadaRepository->update($chamada['data'], $idChamada);
        } catch (ModelNotFoundException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    function desembarquePassageiro(Request $request, $idChamada){
        $data = ['chamada_id' => $idChamada];
        \Validator::make($data, [
            'chamada_id'=>'required|exists:transporte_chamadas,id'
        ])->validate();
        try {
            $chamada = $this->chamadaRepository->find($data['chamada_id']);

            if (is_null($chamada['data'])) {
                throw new \Exception('chamada invalida');
            }
            if (!($chamada['data']['fornecedor_id'] == $this->getUserId())) {
                throw new \Exception('chamada não pertence a você');
            }
            $chamada['data']['datahora_desembarcou'] = Carbon::now();
            $chamada['data']['tipo'] = Chamada::TIPO_FINALIZADO;
            $this->getUser()->disponivel = true;
            $this->getUser()->save();
            return $this->chamadaRepository->update($chamada['data'], $idChamada);
        } catch (ModelNotFoundException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    function avaliacao(Request $request, $idChamada)
    {
        $data = $request->only(['avaliacao']);
        $data['chamada_id'] = $idChamada;
        \Validator::make($data, [
            'avaliacao' => 'required|integer|max:5|min:0',
            'chamada_id'=>'exists:transporte_chamadas,id'
        ])->validate();
        try {
            $chamada = $this->chamadaRepository->find($data['chamada_id']);
            if (is_null($chamada['data'])) {
                throw new \Exception('chamada invalida');
            }
            if (!($chamada['data']['cliente_id'] == $this->getUserId())) {
                throw new \Exception('chamada não pertence a você');
            }
            $chamada['data']['tipo'] = Chamada::TIPO_FINALIZADO;
            $chamada['data']['avaliacao'] = $data['avaliacao'];
            $this->chamadaRepository->update($chamada, $data['chamada_id']);
            return $chamada;
        } catch (ModelNotFoundException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST,  $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    function calcularRota(Request $request)
    {
        $data = $request->only(['origem', 'destino', 'forma_pagamento_id']);
        \Validator::make($data, [
            'origem' => 'required|array',
            'destino' => 'required|array',
            'forma_pagamento_id' => 'required|integer|min:1',
        ])->validate();
        return ['data' => ['valor' => $this->geoService->distanceCalculate($data['origem'], $data['destino'])]];
    }


}
