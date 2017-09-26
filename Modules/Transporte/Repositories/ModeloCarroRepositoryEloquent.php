<?php

namespace Modules\Transporte\Repositories;

use Modules\Transporte\Presenters\ModeloCarroPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Transporte\Repositories\ModeloCarroRepository;
use Modules\Transporte\Models\ModeloCarro;
use Portal\Validators\ModeloCarroValidator;

/**
 * Class ModeloCarroRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class ModeloCarroRepositoryEloquent extends BaseRepository implements ModeloCarroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ModeloCarro::class;
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
        return ModeloCarroPresenter::class;
    }
}
