<?php

namespace Modules\Transporte\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Transporte\Repositories\chamadaRepository;
use Modules\Transporte\Models\Chamada;
use Portal\Validators\ChamadaValidator;

/**
 * Class ChamadaRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class ChamadaRepositoryEloquent extends BaseRepository implements ChamadaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Chamada::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
