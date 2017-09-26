<?php
/**
 * Created by PhpStorm.
 * User: pc05
 * Date: 17/05/2017
 * Time: 17:22
 */

namespace Modules\Plano\Services;


use Modules\Anuncio\Models\Anuncio;
use Modules\Plano\Models\PlanoContratacao;
use Modules\Plano\Repositories\FormaPagamentoRepository;
use Modules\Plano\Repositories\LancamentoRepository;
use Modules\Plano\Repositories\PlanoContratacaoRepository;

class PagSeguroService
{
    private $formaPagamentoRepository;
    /**
     * @var PlanoContratacaoRepository
     */
    private $planoContratacaoRepository;
    /**
     * @var LancamentoRepository
     */
    private $lancamentoRepository;

    public function __construct(
        FormaPagamentoRepository $formaPagamentoRepository,
        PlanoContratacaoRepository $planoContratacaoRepository,
        LancamentoRepository $lancamentoRepository
    )
    {
        $this->formaPagamentoRepository = $formaPagamentoRepository;
        $this->planoContratacaoRepository = $planoContratacaoRepository;
        $this->lancamentoRepository = $lancamentoRepository;
    }

    public function getSessionId()
    {
        $credentials = \PagSeguroConfig::getAccountCredentials();
        return [
            'sessionId' => \PagSeguroSessionService::getSession($credentials)
        ];
    }

    public function pagamentoByMethod($data)
    {
        $contratacao = $this->planoContratacaoRepository->skipPresenter(true)->find($data['code_contratacao']);
        if($contratacao->anuncio->count() == 0)
            throw new \Exception('Erro ao contratar anuncio!');
        if($contratacao->valor == 0){
            $contratacao->status = PlanoContratacao::STATUS_ATIVO;
            $anuncio = $contratacao->anuncio->first();
            $anuncio->status = Anuncio::STATUS_ATIVO;
            $anuncio->save();
            $contratacao->save();
            return [
                'message' => 'o pagamente realizado com sucesso!',
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

        $directPaymentRequest->addItem("001", $contratacao->plano->nome, 1, (double)$contratacao->total);
        $directPaymentRequest->setSender(
            'João Comprador',
            'joao@sandbox.pagseguro.com.br',
            '11',
            '56273440',
            'CPF',
            '156.009.442-76'
        );

        $directPaymentRequest->setSenderHash($hash);

        $installments = new \PagSeguroDirectPaymentInstallment([
            'quantity' => 1,
            'value' => (double)$contratacao->total
        ]);

        //$sedexCode = \PagSeguroShippingType::getCodeByType('SEDEX');
        $sedexCode = \PagSeguroShippingType::getCodeByType('NOT_SPECIFIED');
        $directPaymentRequest->setShippingType($sedexCode);
        $directPaymentRequest->setShippingAddress(
            '01452002',
            'Av. Brig. Faria Lima',
            '1384',
            'apto. 114',
            'Jardim Paulistano',
            'São Paulo',
            'SP',
            'BRA'
        );

        if ($method == 'CREDIT_CARD') {
            $this->cartaoDados($data['token'], $installments, $directPaymentRequest);
        }

        try {

            $credentials = \PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()
            $response = $directPaymentRequest->register($credentials);

            $retorno = [
                'forma_pagamento_id' => $formaPagamento->id,
                'plano_contratacao_id' => $contratacao->id,
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
                        'link'=> $response->getPaymentLink(),
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

    private function cartaoDados($token, $installments, &$directPaymentRequest, $user = null)
    {
        $billingAddress = new \PagSeguroBilling(
            array(
                'postalCode' => '01452002',
                'street' => 'Av. Brig. Faria Lima',
                'number' => '1384',
                'complement' => 'apto. 114',
                'district' => 'Jardim Paulistano',
                'city' => 'São Paulo',
                'state' => 'SP',
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
                        'name' => 'João Comprador',
                        //'birthDate' => date('01/10/1979'),
                        'areaCode' => '11',
                        'number' => '56273440',
                        'documents' => array(
                            'type' => 'CPF',
                            'value' => '156.009.442-76'
                        )
                    )
                )
            )
        );

        $directPaymentRequest->setCreditCard($creditCardData);
    }
}