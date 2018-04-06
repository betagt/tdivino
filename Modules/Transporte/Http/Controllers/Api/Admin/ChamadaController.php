<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Core\Models\User;
use Modules\Localidade\Services\GeoService;
use Modules\Transporte\Consts\ChamadaRemover;
use Modules\Transporte\Criteria\ChamadaClienteCriteria;
use Modules\Transporte\Criteria\ChamadaCriteria;
use Modules\Transporte\Criteria\ChamadaFornecedorCriteria;
use Modules\Transporte\Events\ChamadaAceita;
use Modules\Transporte\Events\ChamadaCancelar;
use Modules\Transporte\Events\ChamadaDesembarque;
use Modules\Transporte\Events\ChamadaEmbarque;
use Modules\Transporte\Events\ChamadaMotoristaNoLocal;
use Modules\Transporte\Events\ChamarMotorista;
use Modules\Transporte\Events\FinalizarChamada;
use Modules\Transporte\Events\RemoverChamada;
use Modules\Transporte\Http\Requests\ChamadaRequest;
use Modules\Transporte\Notifications\IniciarChamadaNotify;
use Modules\Transporte\Repositories\ChamadaRepository;
use Modules\Transporte\Repositories\GeoPosicaoRepository;
use Modules\Transporte\Services\ChamadaNotificacaoService;
use Modules\Transporte\Services\ChamadaOneSginalService;
use Modules\Transporte\Services\PagamentoMoipService;
use Portal\Criteria\OrderCriteria;
use Portal\Http\Controllers\BaseController;

use Modules\Transporte\Models\Chamada;
use Portal\Services\ConfiguracaoService;
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
    /**
     * @var ConfiguracaoService
     */
    private $configuracaoService;
    /**
     * @var ChamadaNotificacaoService
     */
    private $chamadaNotificacaoService;
    /**
     * @var PagamentoMoipService
     */
    private $pagamentoMoipService;

    public function __construct(
        ChamadaRepository $chamadaRepository,
        GeoService $geoService,
        GeoPosicaoRepository $geoPosicaoRepository,
        ConfiguracaoService $configuracaoService,
        ChamadaNotificacaoService $chamadaNotificacaoService,
        PagamentoMoipService $pagamentoMoipService)
    {
        parent::__construct($chamadaRepository, ChamadaCriteria::class);
        $this->chamadaRepository = $chamadaRepository;
        $this->geoService = $geoService;
        $this->geoPosicaoRepository = $geoPosicaoRepository;
        $this->configuracaoService = $configuracaoService;
        $this->chamadaNotificacaoService = $chamadaNotificacaoService;
        $this->pagamentoMoipService = $pagamentoMoipService;
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

    function listarByCliente(Request $request)
    {
        try {
            $result = $this->chamadaRepository
                ->pushCriteria(new OrderCriteria($request))
                ->pushCriteria(new ChamadaClienteCriteria($request, $this->getUserId()))
                ->paginate(self::$_PAGINATION_COUNT);
            return $result;
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    function listarByFornecedorAgencia($id, Request $request)
    {

        try {
            $result = $this->chamadaRepository
                ->pushCriteria(new ChamadaFornecedorCriteria($request, $id))
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

        $data = $request->only(['origem', 'destino', 'forma_pagamento_id', 'endereco_origem', 'endereco_destino']);

        \Validator::make($data, [
            'endereco_origem' => 'required|string',
            'endereco_destino' => 'required|string',
            'origem' => 'required|array',
            'forma_pagamento_id' => 'required|integer',
            'destino' => 'required|array'
        ])->validate();
        $data['cliente_id'] = $this->getUserId();
        $data['tipo'] = Chamada::TIPO_SOLICITACAO;
        $data['status'] = Chamada::STATUS_PENDENTE;
        $result = $this->geoService->distanceCalculate($data['origem'], $data['destino']);
        $data['valor'] = $result['valor'];
        $data['km_rodado'] = $result['distanciatotal'];
        $data['tx_uso_malha'] = $result['tx_uso_malha'];
        $data['tarifa_operacao'] = $result['tarifa_operacao'];
        $data['valor_repasse'] = $result['valor_repasse'];
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
            //$this->chamadaNotificacaoService->iniciarChamada($chamada);
            /*ChamadaOneSginalService::sendNotificationUsingTags("Voce possui uma chamada :".$this->getUser()->device_uuid,[[
                'key'=>'chamada_type',
                'relation'=>'is',
                'value'=>'motorista']
            ],null, ['teste','teste']);*/
            //\OneSignal::sendNotificationToAll("Voce possui uma chamada :".$this->getUser()->device_uuid, null, ['teste'=>'teste'], null, '566f88f5-99f0-4aec-8b9d-f76b3a3cff59');
            //\OneSignal::sendNotificationToSegment('teste', '566f88f5-99f0-4aec-8b9d-f76b3a3cff59', $chamada);
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
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, $e->getMessage());
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

        try {
            \DB::beginTransaction();
            $chamada = $this->chamadaRepository->find($idChamada);

            if (empty($chamada['data'])) {
                return parent::responseError(self::HTTP_CODE_BAD_REQUEST, 'Chamada inválida');
            }

            if ($chamada['data']['tipo'] == Chamada::TIPO_ATENDIMENTO) {
                return parent::responseError(self::HTTP_CODE_BAD_REQUEST, 'Está chamada já está em atendimento.');
            }

            if (!in_array(User::FORNECEDOR, $this->getUser()->getRoles())) {
                return parent::responseError(self::HTTP_CODE_BAD_REQUEST, 'Apenas fornecedores podem aceitar chamadas.');
            }
            if (!$this->getUser()->habilitado) {
                return parent::responseError(self::HTTP_CODE_BAD_REQUEST, 'Você possui pendencia favor entrar em contato com a levez.');
            }
            if($chamada['data']['status'] == Chamada::STATUS_CANCELADO){
                return parent::responseError(self::HTTP_CODE_BAD_REQUEST, 'Chamada já está cancelada por favor realize outra chamada.');
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
			$configuracao = $this->configuracaoService->getConfiguracao();
			$data['timedown'] = Carbon::now()->addMinute($configuracao['data']['tempo_cancel_cliente_min']);

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
            event(new RemoverChamada($chamada->id, ChamadaRemover::REMOVE_CHAMADA));
            \DB::commit();
            unset($response['data']['fornecedor']['data']['pendencias']);
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
            if ($chamada['data']['tipo'] == Chamada::TIPO_ATENDIMENTO) {
				$endTime = new \DateTime($chamada['data']['timedown']);
				$currentTime = Carbon::now();
				if ($currentTime > $endTime) {
					throw new \Exception('O tmepo de cancelamento está expirado');
				}
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
            if(is_null($chamada->fornecedor)) {
                event(new RemoverChamada($chamada->id, ChamadaRemover::REMOVE_CHAMADA));
            }
            if(!is_null($chamada->fornecedor)){
                event(new FinalizarChamada($chamada->fornecedor->device_uuid, 'chamada finalizada'));
                //$this->chamadaNotificacaoService->cancelar_chamada( 'chamada finalizada', $chamada->fornecedor->device_uuid, 'motorista');
            }
            \DB::commit();
            return $response;
        } catch (ModelNotFoundException $e) {
			\DB::rollBack();
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
			\DB::rollBack();
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
			\DB::rollBack();
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
            if (!($chamada->fornecedor_id == $this->getUserId())) {
                throw new \Exception('chamada não pertence a você');
            }
            event(new ChamadaMotoristaNoLocal($chamada->cliente->device_uuid, "Motorista aguardando no local indicado!"));
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
			\DB::beginTransaction();
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
            $endTime = new \DateTime($chamada['data']['timedown']);
            $currentTime = Carbon::now();
            if ($currentTime > $endTime) {
                throw new \Exception('O tmepo de cancelamento está expirado');
            }
            $chamada['status'] = Chamada::STATUS_CANCELADO;
            $this->chamadaRepository->update($chamada, $idChamada);
			event(new ChamadaCancelar($chamada['data']['cliente']['data']['device_uuid'], 'chama foi cancelada', User::CLIENTE));
            //$this->chamadaNotificacaoService->cancelar_chamada( 'chamada finalizada', 'passageiro');
			\DB::commit();
            return $chamada;
        } catch (ModelNotFoundException $e) {
			\DB::rollBack();
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
			\DB::rollBack();
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
			\DB::rollBack();
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        }
    }

    function embarquePassageiro(Request $request, $idChamada){
        $data = ['chamada_id' => $idChamada];
        $embarque = $request->only([
            'hash_pagamento'
        ]);
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
            if(is_null($embarque['hash_pagamento']) && $chamada['data']['forma_pagamento_id'] == 3){
                throw new \Exception('pagamento não informado');
            }else if(!is_null($embarque['hash_pagamento']) && $chamada['data']['forma_pagamento_id'] == 3){
               $pagamento = $this->pagamentoMoipService->capturarPagamento($embarque['hash_pagamento']);
            }
            $chamada['data']['datahora_embarque'] = Carbon::now();
            $chamada['data']['tipo'] = Chamada::TIPO_EMBARCADO;
			$response = $this->chamadaRepository->skipPresenter(true)->find($idChamada);
			//$this->chamadaNotificacaoService->embarque_motorista($chamada, $response->cliente->device_uuid);
			event(new ChamadaEmbarque($response->cliente->device_uuid, $chamada, 'fornecedor'));
            return $this->chamadaRepository->skipPresenter(false)->update($chamada['data'], $idChamada);
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
			$response = $this->chamadaRepository->skipPresenter(true)->find($idChamada);
			event(new ChamadaDesembarque($response->cliente->device_uuid, $chamada, 'cliente'));
            return $this->chamadaRepository->skipPresenter(false)->update($chamada['data'], $idChamada);
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
            $this->chamadaRepository->update($chamada['data'], $data['chamada_id']);
            return $chamada;
        } catch (ModelNotFoundException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST,  $e->getMessage());
        }
    }

    function finalizarChamda($idChamada){
        try {
            $chamada = $this->chamadaRepository->find($idChamada);
            if ($chamada->status == Chamada::STATUS_CANCELADO) {
                throw new \Exception('chamada já cancelada');
            }
            if (is_null($chamada)) {
                throw new \Exception('chamada invalida');
            }
            if (!($chamada->cliente_id == $this->getUserId())) {
                throw new \Exception('chamada não pertence a você');
            }

            $chamada['tipo'] = Chamada::TIPO_FINALIZADO;
            $chamada = $this->chamadaRepository->skipPresenter(true)->update($chamada, $idChamada);
            $response = $this->chamadaRepository->skipPresenter(false)->find($idChamada);
            event(new FinalizarChamada($chamada->fornecedor->device_uuid, 'chamada finalizada'));
            return $response;
        } catch (ModelNotFoundException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'message' => $e->getMessage()]));
        } catch (\Exception $e) {
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, $e->getMessage());
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
        return ['data' => $this->geoService->distanceCalculate($data['origem'], $data['destino'])];
    }

    function pagar($idPagamento){
        return $this->pagamentoMoipService->capturarPagamento($idPagamento);
    }

}
