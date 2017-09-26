<?php

namespace Portal\Services;

use Portal\Repositories\PaginaRepository;


/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 03/01/17
 * Time: 14:49
 */
class UtilService
{
    public function __construct()
    {
    }

    public function curlFunction($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function curlFunctionProxy($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($this->check("192.168.2.254:3128")){
            curl_setopt($ch, CURLOPT_PROXY, "http://192.168.2.254"); //your proxy url
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "diuliano:123456"); //username:pass
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function check($proxy=null)
    {
        $proxy=  explode(':', $proxy);
        $host = $proxy[0];
        $port = $proxy[1];
        $waitTimeoutInSeconds = 10;

        if($fp = @fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }

}