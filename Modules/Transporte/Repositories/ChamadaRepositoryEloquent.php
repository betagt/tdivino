<?php

namespace Modules\Transporte\Repositories;

use Modules\Transporte\Presenters\ChamadaPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Transporte\Repositories\chamadaRepository;
use Modules\Transporte\Models\Chamada;
use Portal\Validators\ChamadaValidator;

/**
 * Class ChamadaRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class ChamadaRepositoryEloquent extends BaseRepository implements ChamadaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Chamada::class;
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
        return ChamadaPresenter::class;
    }

    public function somaFornecedorTotais($userId)
    {
        return $this->model->where([
            'fornecedor_id'=>$userId,
        ])->where(function($query){
            $query->whereOr(['status'=>'pago']);
            $query->whereOr(['status'=>'sacado']);
        })->sum('valor');
    }

    public function somaFornecedorMes($userId)
    {
        return $this->model->where([
            'fornecedor_id'=>$userId
        ])->where(function($query){
            $query->whereOr(['status'=>'pago']);
            $query->whereOr(['status'=>'sacado']);
        })->whereBetween('created_at', [date('Y-m-01'), date("Y-m-t")])->sum('valor');
    }

    public function somaFornecedorSemana($userId)
    {
        $date = date("Y-m-d");
        return $this->model->where([
            'fornecedor_id'=>$userId,
            'status'=>'pago'
        ])->where(function($query){
            $query->whereOr(['status'=>'pago']);
            $query->whereOr(['status'=>'sacado']);
        })->whereBetween('created_at', [
            date("Y-m-d", strtotime('monday this week', strtotime($date))),
            date("Y-m-d", strtotime('sunday this week', strtotime($date)))])->sum('valor');
    }

    public function somaFornecedorHoje($userId)
    {
        return $this->model->where([
            'fornecedor_id'=>$userId,
            'created_at'=>date("Y-m-d")
        ])->where(function($query){
            $query->whereOr(['status'=>'pago']);
            $query->whereOr(['status'=>'sacado']);
        })->sum('valor');
    }
}
