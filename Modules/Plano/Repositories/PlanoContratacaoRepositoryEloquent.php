<?php

namespace Modules\Plano\Repositories;

use Modules\Plano\Presenters\PlanoContratacaoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Plano\Repositories\PlanoContratacaoRepository;
use Modules\Plano\Models\PlanoContratacao;
use Modules\Plano\Validators\PlanoContratacaoValidator;

/**
 * Class PlanoContratacaoRepositoryEloquent
 * @package namespace Modules\Plano\Repositories;
 */
class PlanoContratacaoRepositoryEloquent extends BaseRepository implements PlanoContratacaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanoContratacao::class;
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
        return PlanoContratacaoPresenter::class;
    }

    public function createByAnuncio(array $data)
    {
        // TODO: Implement createByAnuncio() method.
    }

    public function updateByAnuncio(array $data, int $id)
    {
        // TODO: Implement updateByAnuncio() method.
    }
}
