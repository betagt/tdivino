<?php

namespace Modules\Plano\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PlanoRepository
 * @package namespace Modules\Plano\Repositories;
 */
interface PlanoRepository extends RepositoryInterface
{
    public function findByTipoClienteEstadoCidade($tipo_cliente, $estado, $cidade);
}
