<?php

namespace Modules\Plano\Criteria;

use Illuminate\Database\Eloquent\Model;
use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PlanoCriteria
 * @package namespace Modules\Plano\Criteria;
 */
class PlanoCriteria extends BaseCriteria implements CriteriaInterface
{

    protected $filterCriteria = [
        'planos.nome' => 'ilike',
        'planos.created_at' => 'between'
    ];

    public function apply($model, RepositoryInterface $repository)
    {
        $model = parent::apply($model, $repository);
        return $model;
    }

}
