<?php

namespace Modules\Transporte\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface DocumentoRepository
 * @package namespace Portal\Repositories;
 */
interface DocumentoRepository extends RepositoryInterface
{
    public function documentosVencidos($tipo = null);
}
