<?php

namespace Modules\Plano\Repositories;

use Modules\Plano\Models\FormaPagamento;
use Modules\Plano\Presenters\FormaPagamentoPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class FormaPagamentoRepositoryEloquent
 * @package namespace Modules\Plano\Repositories;
 */
class FormaPagamentoRepositoryEloquent extends BaseRepository implements FormaPagamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FormaPagamento::class;
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
        return FormaPagamentoPresenter::class;
    }

    /**
     * @return todas as formas ativas
     */
    public function formasAtivas()
    {
        return $this->findWhere(['status'=>true]);
    }
}
