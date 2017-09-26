<?php

namespace  Modules\Transporte\Repositories;

use Modules\Transporte\Presenters\ServicoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use  Modules\Transporte\Repositories\ServicoRepository;
use  Modules\Transporte\Models\Servico;
use  Modules\Transporte\Validators\ServicoValidator;

/**
 * Class ServicoRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class ServicoRepositoryEloquent extends BaseRepository implements ServicoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Servico::class;
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
        return ServicoPresenter::class;
    }
}
