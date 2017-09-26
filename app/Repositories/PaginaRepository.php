<?php

namespace Portal\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PaginaRepository
 * @package namespace Portal\Repositories;
 */
interface PaginaRepository extends RepositoryInterface
{
    public function findBySlug($slug);
}
