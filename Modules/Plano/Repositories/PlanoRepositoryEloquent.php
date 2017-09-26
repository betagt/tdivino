<?php

namespace Modules\Plano\Repositories;

use Modules\Plano\Models\Plano;
use Modules\Plano\Presenters\PlanoPresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PlanoRepositoryEloquent
 * @package namespace Modules\Plano\Repositories;
 */
class PlanoRepositoryEloquent extends BaseRepository implements PlanoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Plano::class;
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
        return PlanoPresenter::class;
    }

    public function findByTipoClienteEstadoCidade($tipo_cliente, $estado, $cidade)
    {
        $result = $this->model
            ->join('plano_tabela_precos as tabela_preco','tabela_preco.plano_id','planos.id')
            ->join('estados','estados.id','tabela_preco.estado_id')
            ->join('cidades','cidades.id','tabela_preco.cidade_id')
            ->where('estados.uf', '=', $estado)
            ->where('cidades.titulo', '=', $cidade)
            ->where('planos.tipo', '=', $tipo_cliente)
            ->select('planos.*', 'tabela_preco.valor')
            ->orderBy('planos.id', 'asc')
            ->orderBy('tabela_preco.id', 'desc')
            ->get();

        if($result->count() == 0){
            return $this->parserResult($this->model->where('planos.tipo', '=', $tipo_cliente)->orderBy('planos.id', 'desc')->get());
        }

        if($result){
            return $this->parserResult($result);
        }

        throw (new ModelNotFoundException())->setModel($this->model());

    }
}
