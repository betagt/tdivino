<?php

namespace Modules\Plano\Criteria;

use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class LancamentoCriteria
 * @package namespace Portal\Criteria;
 */
class LancamentoCriteria extends BaseCriteria implements CriteriaInterface
{

    protected $filterCriteria = [
        'plano_tabela_precos.plano_id' => '=',
        'lancamentos.forma_pagamento_id' => '=',
        'plano_tabela_precos.cidade_id' => '='
    ];

    /**
     * Apply criteria in query repository
     *
     * @param       Model $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     *
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = parent::apply($model, $repository);
        return $model
            ->where('plano_contratacao_id', $this->request->get('contratacao'));
    }
}
