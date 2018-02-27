<?php

namespace Modules\Transporte\Repositories;

use Modules\Transporte\Models\FinanceiroConta;
use Modules\Transporte\Presenters\FinanceiroContaPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Transporte\Models\Veiculo;
use Modules\Transporte\Validators\VeiculoValidator;

/**
 * Class VeiculoRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class FinanceiroContaRepositoryEloquent extends BaseRepository implements FinanceiroContaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FinanceiroConta::class;
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
        return FinanceiroContaPresenter::class;
    }
}
