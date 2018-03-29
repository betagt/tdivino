<?php
/**
 * Created by PhpStorm.
 * User: DIX-SUPORTE
 * Date: 29/03/2018
 * Time: 20:13
 */

namespace Modules\Transporte\Services;


class PagamentoMoipService
{
    private $moip;

    public function __construct(\Moip $moip)
    {
        $this->moip = $moip;
    }

    /**
     * @param $idPagamento
     * @return mixed
     */
    public function capturarPagamento($idPagamento){
        $payment = $this->getPagamento($idPagamento);
        /** @var \Moip\Resource\Payment $payment */
        try{
            return $payment->capture();
        }catch (\Exception $e){
            return $e;
        }
    }

    /**
     * @param $idPagamento
     * @return mixed
     */
    public function cancelarPagamento($idPagamento){
        $payment = $this->getPagamento($idPagamento);
        /** @var \Moip\Resource\Payment $payment */
        try{
            return $payment->cancel();
        }catch (\Exception $e){
            return $e;
        }
    }


    private function getPagamento($idPagamento){
        return $this->moip->payments()->get($idPagamento);;
    }
}