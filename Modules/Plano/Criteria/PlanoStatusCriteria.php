<?php

namespace Modules\Plano\Criteria;

use Illuminate\Http\Request;
use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;


/**
 * Class MensagemAnuncioCriteria
 * @package namespace Portal\Criteria;
 */
class PlanoStatusCriteria  implements CriteriaInterface
{


    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('status', '=', true);
    }
}
