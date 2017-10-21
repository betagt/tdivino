<?php

namespace Modules\Transporte\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ChamadaRepository
 * @package namespace Portal\Repositories;
 */
interface ChamadaRepository extends RepositoryInterface
{
    public function somaFornecedorTotais($userId);
    public function somaFornecedorMes($userId);
    public function somaFornecedorSemana($userId);
    public function somaFornecedorHoje($userId);
}
