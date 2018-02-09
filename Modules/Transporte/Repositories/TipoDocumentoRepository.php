<?php

namespace Modules\Transporte\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface HabilidadeRepository
 * @package namespace Portal\Repositories;
 */
interface TipoDocumentoRepository extends RepositoryInterface
{
    public function validadeUser(int $userId);
}
