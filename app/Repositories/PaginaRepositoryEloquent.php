<?php

namespace Portal\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Portal\Presenters\PaginaPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Portal\Models\Pagina;

/**
 * Class PaginaRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class PaginaRepositoryEloquent extends BaseRepository implements PaginaRepository
{


    public function model()
    {
        return Pagina::class;
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
        return PaginaPresenter::class;
    }

    public function findBySlug($slug)
    {
        $result = $this->model->where('slug', $slug)->first();

        if($result){
            return $this->parserResult($result);
        }

        throw (new ModelNotFoundException())->setModel($this->model());

    }
}
