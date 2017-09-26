<?php

namespace Portal\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Portal\Repositories\BuscaAlertaRepository;
use Portal\Models\BuscaAlerta;
use Portal\Validators\BuscaAlertaValidator;

/**
 * Class BuscaAlertaRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class BuscaAlertaRepositoryEloquent extends BaseRepository implements BuscaAlertaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BuscaAlerta::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
