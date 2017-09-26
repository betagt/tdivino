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
class PlanoCidadesCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $estadoId;
    /**
     * @var
     */
    private $cidadeId;

    public function __construct($estadoId, $cidadeId)
    {
        $this->estadoId = $estadoId;
        $this->cidadeId = $cidadeId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->leftJoin('plano_tabela_precos', function($join)
            {
                $join->on('planos.id', 'plano_tabela_precos.plano_id');
                $join->on('plano_tabela_precos.estado_id','=', \DB::raw($this->estadoId));
                $join->on('plano_tabela_precos.cidade_id','=', \DB::raw($this->estadoId));
            })
            ->groupBy('planos.id')
            ->orderBy('planos.valor')
            ->select(['planos.*',\DB::raw('CASE sum(plano_tabela_precos.valor) is null WHEN true THEN planos.valor ELSE sum(plano_tabela_precos.valor) END as valor')]);
    }

}
