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

    function getMoip(){
    	return $this->moip;
	}

    /**
     * @param $idPagamento
     * @return mixed
     */
    public function capturarPagamento($idPagamento){
        $payment = $this->getPagamento($idPagamento);
        /** @var \Moip\Resource\Payment $payment */
        try{
            return $payment->authorize();
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
		$orders = $this->moip::orders()->get($idPagamento);
		/** @var \Moip\Resource\Orders $orders */
    	//dd($orders->getPaymentIterator()->current()->capture());//MPA-ED4A20C187A4
		/** @var \Moip\Resource\Payment $payment */
		/*$payment = $orders->getPaymentIterator()->current();
		$payment = $payment->setDelayCapture();
		dd($payment->capture());*/
        return $orders->getPaymentIterator()->current();
    }

}