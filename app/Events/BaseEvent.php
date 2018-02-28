<?php
/**
 * Created by PhpStorm.
 * User: DIX-SUPORTE
 * Date: 28/02/2018
 * Time: 19:25
 */

namespace Portal\Events;


abstract class BaseEvent
{
    public static function checkProd(){
        return !env('PUSHER_PROD')?"dev.":null;
    }
}