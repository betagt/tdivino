<?php
/**
 * Created by PhpStorm.
 * User: pc05
 * Date: 17/05/2017
 * Time: 17:22
 */

namespace Modules\Plano\Services;


use Modules\Anuncio\Models\Anuncio;
use Modules\Core\Models\User;
use Modules\Plano\Models\PlanoContratacao;
use Modules\Plano\Repositories\FormaPagamentoRepository;
use Modules\Plano\Repositories\LancamentoRepository;
use Modules\Plano\Repositories\PlanoContratacaoRepository;
use Modules\Transporte\Models\Chamada;
use Modules\Transporte\Repositories\ChamadaRepository;

class PagSeguroService
{
    private $formaPagamentoRepository;
    /**
     * @var LancamentoRepository
     */
    private $lancamentoRepository;
    /**
     * @var ChamadaRepository
     */
    private $chamadaRepository;

    public function __construct(
        FormaPagamentoRepository $formaPagamentoRepository,
        LancamentoRepository $lancamentoRepository,
        ChamadaRepository $chamadaRepository
    )
    {
        $this->formaPagamentoRepository = $formaPagamentoRepository;
        $this->lancamentoRepository = $lancamentoRepository;
        $this->chamadaRepository = $chamadaRepository;
    }

    public function getSessionId()
    {
        $credentials = \PagSeguroConfig::getAccountCredentials();
        return [
            'sessionId' => \PagSeguroSessionService::getSession($credentials)
        ];
    }

    public function pagamentoByMethod($data, User $user = null)
    {
        $chamada = $this->chamadaRepository->skipPresenter(true)->find($data['code_chamada']);
        if (is_null($chamada))
            throw new \Exception('Erro ao contratar anuncio!');
        if ($chamada->valor == 0) {
            $chamada->status = Chamada::STATUS_PAGO;
            $chamada->save();
            return [
                'message' => 'o pagamento realizado com sucesso!',
                'success' => true,
            ];
        }
        $formaPagamento = $this->formaPagamentoRepository->skipPresenter(true)->findByField('slug', $data['forma_pagamento'])->first();
        $method = $data['method'];
        $hash = $data['hash'];

        $directPaymentRequest = new \PagSeguroDirectPaymentRequest();
        $directPaymentRequest->setPaymentMode('DEFAULT'); // GATEWAY
        $directPaymentRequest->setPaymentMethod($method);

        $directPaymentRequest->setCurrency("BRL");

        /*foreach ($items as $key => $item){
            $directPaymentRequest->addItem("00$key",$item['name'],1,$item['price']);
        }*/

        $directPaymentRequest->addItem("001", 'Corrida realizada', 1, (double)$chamada->valor);
        $directPaymentRequest->setSender(
            $user->nome,
            $user->email,
            $user->telefone->ddd,
            $user->telefone->numero,
            'CPF',
            $user->cpf
        );

        $directPaymentRequest->setSenderHash($hash);

        $installments = new \PagSeguroDirectPaymentInstallment([
            'quantity' => 1,
            'value' => (double)$chamada->valor
        ]);

        //$sedexCode = \PagSeguroShippingType::getCodeByType('SEDEX');
        $sedexCode = \PagSeguroShippingType::getCodeByType('NOT_SPECIFIED');
        $directPaymentRequest->setShippingType($sedexCode);
        $directPaymentRequest->setShippingAddress(
            $user->endereco->cep,
            $user->endereco->rua,
            $user->endereco->numero,
            $user->endereco->complemento,
            $user->endereco->bairro,
            $user->endereco->cidade->titulo,
            $user->endereco->estado->uf,
            'BRA'
        );

        if ($method == 'CREDIT_CARD') {
            $this->cartaoDados($data['token'], $installments, $directPaymentRequest, $user);
        }

        try {

            $credentials = \PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()
            $response = $directPaymentRequest->register($credentials);

            $retorno = [
                'forma_pagamento_id' => $formaPagamento->id,
                'lancamentotable_id' => $chamada->id,
                'lancamentotable_type' => Chamada::class,
                'codigo' => $response->getCode(),
                'metodo' => $method,
                'valor_liquido' => $response->getNetAmount(),
                'taxa' => $response->getFeeAmount(),
                'valor' => $response->getGrossAmount(),
                'ultima_atualizacao' => $response->getLastEventDate(),
                'status' => $response->getStatus()->getValue(),
                'desconto' => (double)$response->getDiscountAmount(),
            ];
            switch ($method) {
                case 'BOLETO':
                    $this->lancamentoRepository->create(array_merge($retorno, ['link_externo' => $response->getPaymentLink()]));
                    return [
                        'message' => 'boleto gerado com sucesso',
                        'link' => $response->getPaymentLink(),
                        'success' => true,
                    ];
                    break;
                case 'CREDIT_CARD':
                    $this->lancamentoRepository->create($retorno);
                    return [
                        'message' => 'o pagamente está em Análise',
                        'success' => true,
                    ];
                    break;
            }

        } catch (\PagSeguroServiceException $e) {
            return [
                'message' => $e->getMessage(),
                'success' => false
            ];
        }
    }

    private function cartaoDados($token, $installments, &$directPaymentRequest,User $user = null)
    {
        $billingAddress = new \PagSeguroBilling(
            array(
                'postalCode' => $user->endereco->cep,
                'street' => $user->endereco->rua,
                'number' => $user->endereco->numero,
                'complement' =>  $user->endereco->complemento,
                'district' => $user->endereco->bairro,
                'city' => $user->endereco->cidade->titulo,
                'state' =>  $user->endereco->estado->uf,
                'country' => 'BRA'
            )
        );

        $creditCardData = new \PagSeguroCreditCardCheckout(
            array(
                'token' => $token,
                'installment' => $installments,
                'billing' => $billingAddress,
                'holder' => new \PagSeguroCreditCardHolder(
                    array(
                        'name' => $user->nome,
                        //'birthDate' => date('01/10/1979'),
                        'areaCode' => $user->telefone->ddd,
                        'number' => $user->telefone->numero,
                        'documents' => array(
                            'type' => 'CPF',
                            'value' => $user->cpf
                        )
                    )
                )
            )
        );

        $directPaymentRequest->setCreditCard($creditCardData);
    }
}