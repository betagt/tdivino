<?php

namespace  Modules\Transporte\Repositories;

use Modules\Transporte\Presenters\ContaPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use  Modules\Transporte\Repositories\ContaRepository;
use  Modules\Transporte\Models\Conta;
use  Modules\Transporte\Validators\ContaValidator;

/**
 * Class ContaRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class ContaRepositoryEloquent extends BaseRepository implements ContaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Conta::class;
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
        return ContaPresenter::class;
    }
}
