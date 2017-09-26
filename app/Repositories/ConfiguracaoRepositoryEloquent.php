<?php

namespace Portal\Repositories;

use Portal\Models\Configuracao;
use Portal\Presenters\ConfiguracaoPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ConfiguracaoRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class ConfiguracaoRepositoryEloquent extends BaseRepository implements ConfiguracaoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Configuracao::class;
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
        return ConfiguracaoPresenter::class;
    }
}
