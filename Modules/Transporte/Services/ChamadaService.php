<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 06/01/2017
 * Time: 13:50
 */

namespace Modules\Transporte\Services;

use Modules\Transporte\Repositories\ChamadaRepository;
use Modules\Transporte\Repositories\ServicoRepository;

class ChamadaService
{
    /**
     * @var ChamadaRepository
     */
    private $chamadaRepository;

    public function __construct(
        ChamadaRepository $chamadaRepository)
    {
        $this->chamadaRepository = $chamadaRepository;
    }

    function getChamadaRepository(){
        return $this->chamadaRepository;
    }

    function iniciarChamda($position, $data){
        //TODO implementar chamada
    }

}