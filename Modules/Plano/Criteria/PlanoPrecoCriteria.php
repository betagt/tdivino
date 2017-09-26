<?php

namespace Modules\Plano\Criteria;

use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PlanoPrecoCriteria
 * @package namespace Modules\Plano\Criteria;
 */
class PlanoPrecoCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $filterCriteria = [
        'plano_tabela_precos.plano_id'       =>'=',
        'plano_tabela_precos.estado_id'       =>'=',
        'plano_tabela_precos.cidade_id'   =>'='
    ];

    /**
     * Apply criteria in query repository
     *
     * @param       Model              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     *
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = parent::apply($model, $repository);
        return $model
            ->join('planos','plano_tabela_precos.plano_id','planos.id')
            ->join('estados','estados.id','plano_tabela_precos.estado_id')
            ->join('cidades','cidades.id','plano_tabela_precos.cidade_id')
            ->where('plano_id', $this->request->get('plano'))
            ->select(array_merge($this->defaultTable,['plano_tabela_precos.valor']));
    }
}
