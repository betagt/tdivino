<?php
/**
 * Created by PhpStorm.
 * User: pc05
 * Date: 19/05/2017
 * Time: 15:51
 */

namespace Modules\Plano\Theads;


use Modules\Plano\Services\PagSeguroService;

class PagSeguroSessionIdThead
{
    public $result;
    /**
     * @var PagSeguroService
     */
    private $pagSeguroService;

    public function __construct() {
        print_r((new \Thread()));
        $this->pagSeguroService = app(PagSeguroService::class);
    }

    public function run() {
        $this->result = $this->pagSeguroService->getSessionId();
    }

    public function getResult(){
        return $this->result;
    }
}