<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 17/02/2017
 * Time: 17:16
 */
namespace Portal\Http\Controllers\Api\Admin;

use Portal\Criteria\MensagemFinanceiroCriteria;
use Portal\Http\Controllers\BaseController;
use Portal\Http\Requests\MensagemFinanceiroRequest;
use Portal\Repositories\MensagemFinanceiroRepository;

class MensagemFinanceiroController extends BaseController
{
    /**
     * @var MensagemFinanceiroRepository
     */
    private $mensagemFinanceiroRepository;

    public function __construct(MensagemFinanceiroRepository $mensagemFinanceiroRepository)
    {
        parent::__construct($mensagemFinanceiroRepository, MensagemFinanceiroCriteria::class);
        $this->mensagemFinanceiroRepository = $mensagemFinanceiroRepository;
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new MensagemFinanceiroRequest())->rules();
        return $this->validator;
    }
}