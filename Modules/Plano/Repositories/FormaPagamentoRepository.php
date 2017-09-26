<?php

namespace Modules\Plano\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface FormaPagamentoRepository
 * @package namespace Modules\Plano\Repositories;
 */
interface FormaPagamentoRepository extends RepositoryInterface
{
    /**
     * @return todas as formas ativas
     */
    public function formasAtivas();
}
