<?php

namespace Modules\Transporte\Repositories;

use Modules\Transporte\Presenters\VeiculoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Transporte\Repositories\veiculoRepository;
use Modules\Transporte\Models\Veiculo;
use Modules\Transporte\Validators\VeiculoValidator;

/**
 * Class VeiculoRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class VeiculoRepositoryEloquent extends BaseRepository implements VeiculoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Veiculo::class;
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
        return VeiculoPresenter::class;
    }

    public function habilitarDesabilitar($id)
    {
        $veiculo = $this->skipPresenter(true)->find($id);
        $veiculo->habilitado = !$veiculo->habilitado;
        $veiculo->save();
    }
}
