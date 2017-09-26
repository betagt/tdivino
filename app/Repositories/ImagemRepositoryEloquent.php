<?php

namespace Portal\Repositories;

use Portal\Presenters\ImagemPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Portal\Repositories\ImagemRepository;
use Portal\Models\Imagem;
use Portal\Validators\ImagemValidator;

/**
 * Class ImagemRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class ImagemRepositoryEloquent extends BaseRepository implements ImagemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Imagem::class;
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
        return ImagemPresenter::class;
    }
}
