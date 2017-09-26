<?php

namespace Modules\Plano\Repositories;

use Modules\Plano\Models\PlanoTabelaPreco;
use Modules\Plano\Presenters\PlanoTabelaPrecoPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PlanoTabelaPrecoRepositoryEloquent
 * @package namespace Modules\Plano\Repositories;
 */
class PlanoTabelaPrecoRepositoryEloquent extends BaseRepository implements PlanoTabelaPrecoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanoTabelaPreco::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return PlanoTabelaPrecoPresenter::class;
    }
}
