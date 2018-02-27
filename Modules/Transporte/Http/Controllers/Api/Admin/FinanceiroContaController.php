<?php
/**
 * Created by PhpStorm.
 * User: DIX-SUPORTE
 * Date: 26/02/2018
 * Time: 21:03
 */

namespace Modules\Transporte\Http\Controllers\Api\Admin;


use Modules\Transporte\Criteria\FinanceiroContaCriteria;
use Modules\Transporte\Repositories\FinanceiroContaRepository;
use Portal\Criteria\OrderCriteria;
use Portal\Http\Controllers\BaseController;

class FinanceiroContaController extends BaseController
{

    /**
     * @var FinanceiroContaCriteria
     */
    private $financeiroContaCriteria;

    /**
     * @var FinanceiroContaRepository
     */
    private $financeiroContaRepository;

    public function __construct(FinanceiroContaRepository $financeiroContaRepository, FinanceiroContaCriteria $financeiroContaCriteria)
    {
        parent::__construct($financeiroContaRepository, $financeiroContaCriteria);
        $this->financeiroContaCriteria = $financeiroContaCriteria;
        $this->financeiroContaRepository = $financeiroContaRepository;
    }

    public function getValidator($id = null)
    {
        return [];
    }
}