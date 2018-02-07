<?php

namespace Modules\Transporte\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface VeiculoRepository
 * @package namespace Portal\Repositories;
 */
interface VeiculoRepository extends RepositoryInterface
{
    public function habilitarDesabilitar($id, boolean $habilitado = false);
}
