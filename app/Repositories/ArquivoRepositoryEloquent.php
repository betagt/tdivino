<?php

namespace Portal\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Portal\Repositories\ArquivoRepository;
use Portal\Models\Arquivo;
use Portal\Validators\ArquivoValidator;

/**
 * Class ArquivoRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class ArquivoRepositoryEloquent extends BaseRepository implements ArquivoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Arquivo::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
