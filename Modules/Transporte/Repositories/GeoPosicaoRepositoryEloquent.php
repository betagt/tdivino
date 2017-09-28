<?php

namespace Modules\Transporte\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Transporte\Repositories\GeoPosicaoRepository;
use Modules\Transporte\Models\GeoPosicao;

/**
 * Class GeoPosicaoRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class GeoPosicaoRepositoryEloquent extends BaseRepository implements GeoPosicaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GeoPosicao::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
