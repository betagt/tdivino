<?php
/**
 * Created by PhpStorm.
 * User: DIX-SUPORTE
 * Date: 26/02/2018
 * Time: 21:03
 */

namespace Modules\Transporte\Http\Controllers\Api\Admin;


use Portal\Criteria\OrderCriteria;
use Portal\Http\Controllers\BaseController;

class FinanceiroContaController extends BaseController
{

    public function __construct($defaultRepository, $defaultCriteria, string $defaultOrder = OrderCriteria::class)
    {
        parent::__construct($defaultRepository, $defaultCriteria, $defaultOrder);
    }

    public function getValidator($id = null)
    {
        return [];
    }
}