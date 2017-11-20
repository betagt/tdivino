<?php

namespace Modules\Transporte\Repositories;

use Modules\Transporte\Presenters\BancoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Transporte\Repositories\BancoRepository;
use Modules\Transporte\Models\Banco;
//use Modules\Transporte\Validators\BancoValidator;

/**
 * Class BancoRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class BancoRepositoryEloquent extends BaseRepository implements BancoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Banco::class;
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
		return BancoPresenter::class;
	}
}
