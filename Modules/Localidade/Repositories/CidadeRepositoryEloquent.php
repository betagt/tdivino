<?php

namespace Modules\Localidade\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Localidade\Repositories\CidadeRepository;
use Modules\Localidade\Models\Cidade;
use Modules\Localidade\Validators\CidadeValidator;

/**
 * Class CidadeRepositoryEloquent
 * @package namespace Modules\Localidade\Repositories;
 */
class CidadeRepositoryEloquent extends BaseRepository implements CidadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cidade::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
