<?php

namespace  Modules\Transporte\Repositories;

use Modules\Transporte\Models\Movimentacao;
use Modules\Transporte\Presenters\MovimentacaoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use  Modules\Transporte\Validators\ServicoValidator;

/**
 * Class ServicoRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class MovimentacaoRepositoryEloquent extends BaseRepository implements MovimentacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Movimentacao::class;
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
        return MovimentacaoPresenter::class;
    }
}
