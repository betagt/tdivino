<?php

namespace Modules\Plano\Repositories;

use Modules\Plano\Presenters\LancamentoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Plano\Repositories\LancamentoRepository;
use Modules\Plano\Models\Lancamento;
use Modules\Plano\Validators\LancamentoValidator;

/**
 * Class LancamentoRepositoryEloquent
 * @package namespace Modules\Plano\Repositories;
 */
class LancamentoRepositoryEloquent extends BaseRepository implements LancamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Lancamento::class;
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
        return LancamentoPresenter::class;
    }
}
