<?php

namespace Modules\Transporte\Repositories;

use Modules\Core\Models\User;
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
        $rs = $this->model
            ->leftJoin('transporte_documentos', function ($join) use ($userId) {
                $join->on('transporte_tipo_documentos.id', '=', 'transporte_documentos.transporte_tipo_documento_id');
                $join->where('transporte_documentos.documentotable_type', '=', User::class);
                $join->where('transporte_documentos.documentotable_id', '=', $userId);
            })
            ->groupby('transporte_tipo_documentos.id')
            ->where('transporte_tipo_documentos.tipo', '=', $tipo)
            ->select(['transporte_tipo_documentos.*', \DB::raw('count(transporte_documentos.id) AS contagem')])
            ->get();
        if($rs->count() == 0){
            return null;
        }
        $skypresenter = $this->skipPresenter;
        $data = $this->skipPresenter(false)->parserResult($rs);
        $data['habilitado'] = !in_array(0, array_column($data['data'],'contagem'));
        $this->skipPresenter($skypresenter);
        return $data;
    }
}
