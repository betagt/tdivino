<?php

namespace Modules\Transporte\Repositories;

use Modules\Transporte\Presenters\MarcaCarroPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Transporte\Repositories\MarcaCarroRepository;
use Modules\Transporte\Models\MarcaCarro;

/**
 * Class MarcaCarroRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class MarcaCarroRepositoryEloquent extends BaseRepository implements MarcaCarroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MarcaCarro::class;
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
        return MarcaCarroPresenter::class;
    }
}
