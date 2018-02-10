<?php

namespace Modules\Transporte\Repositories;

use Modules\Core\Models\User;
use Modules\Transporte\Models\Documento;
use Modules\Transporte\Presenters\TipoDocumentoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Transporte\Repositories\TipoDocumentoRepository;
use Modules\Transporte\Models\TipoDocumento;
use Modules\Transporte\Validators\TipoDocumentoValidator;

/**
 * Class HabilidadeRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class TipoDocumentoRepositoryEloquent extends BaseRepository implements TipoDocumentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TipoDocumento::class;
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
        return TipoDocumentoPresenter::class;
    }

    public function validadeUser(int $userId, $tipo = User::MOTORISTA)
    {
        $data = [];
        $rs = $this->model
            ->leftJoin('transporte_documentos', function ($join) use ($userId) {
                $join->on('transporte_tipo_documentos.id', '=', 'transporte_documentos.transporte_tipo_documento_id');
                $join->where('transporte_documentos.documentotable_type', '=', User::class);
                $join->where('transporte_documentos.documentotable_id', '=', $userId);
                $join->where('transporte_documentos.status', '=', Documento::STATUS_ACEITO);
            })
            ->groupby('transporte_tipo_documentos.id')
            ->where('transporte_tipo_documentos.tipo', '=', $tipo)
            ->select(['transporte_tipo_documentos.*', \DB::raw('count(transporte_documentos.id) AS contagem')])
            ->get();

        if($rs->count() == 0){
            $data['data'] = [];
            $data['habilitado'] = false;
            $data['cor'] = 'red';
            return $data;
        }

        $skypresenter = $this->skipPresenter;
        $data = $this->skipPresenter(false)->parserResult($rs);
        $contagem_array = array_column($data['data'],'contagem');
        $max_documento_tipo = count($contagem_array);
        $data['habilitado'] = !in_array(0, $contagem_array);
        $selecao = array_count_values($contagem_array);

        if(isset($selecao[1]) && $selecao[1] == $max_documento_tipo){
            $data['cor'] = 'green';
            $this->skipPresenter($skypresenter);
            return $data;
        }
        if(isset($selecao[0]) && $selecao[0] == $max_documento_tipo){
            $data['cor'] = 'red';
            $this->skipPresenter($skypresenter);
            return $data;
        }
        if($selecao[0] > 0 && $selecao[1] > 0){
            $data['cor'] = 'yellow';
            $this->skipPresenter($skypresenter);
            return $data;
        }

    }
}
