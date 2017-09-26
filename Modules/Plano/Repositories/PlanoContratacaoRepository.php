<?php

namespace Modules\Plano\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PlanoContratacaoRepository
 * @package namespace Modules\Plano\Repositories;
 */
interface PlanoContratacaoRepository extends RepositoryInterface
{
    public function createByAnuncio(array $data);
    public function updateByAnuncio(array $data,int $id);
}
