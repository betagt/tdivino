<?php

namespace Modules\Transporte\Repositories;

use Modules\Core\Models\User;
use Modules\Core\Repositories\UserRepository;
use Modules\Transporte\Models\Veiculo;
use Modules\Transporte\Presenters\DocumentoPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Transporte\Repositories\DocumentoRepository;
use Modules\Transporte\Models\Documento;
use Modules\Transporte\Validators\DocumentoValidator;

/**
 * Class DocumentoRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class DocumentoRepositoryEloquent extends BaseRepository implements DocumentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Documento::class;
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
        return DocumentoPresenter::class;
    }

    public function documentosVencidos($tipo = Documento::tipo_veiculo)
    {
        $documentos = $this->model
            ->join('transporte_tipo_documentos', 'transporte_documentos.transporte_tipo_documento_id', 'transporte_tipo_documentos.id')
            ->where('transporte_tipo_documentos.precisa_de_documento', '=', true)
            //->where('transporte_tipo_documentos.tipo','=',$tipo)
            ->where('transporte_documentos.data_vigencia_fim', '<', \DB::raw('now()'))
            ->where('transporte_documentos.status', '=', 'aceito')
            ->select(['transporte_documentos.*'])->get();
        $documentos->each(function ($documento) {
            if ($documento->documentotable_type == Veiculo::class) {
                //TODO criar eventos para para esse tipo de ação.
                app(VeiculoRepository::class)->habilitarDesabilitar($documento->documentotable_id);
            }
            if ($documento->documentotable_type == User::class) {
                //TODO criar eventos para para esse tipo de ação.
                app(UserRepository::class)->habilitarDesabilitar($documento->documentotable_id);
            }
            $documento->status = Documento::STATUS_VENCIDO;
            $documento->save();
        });
        return $this->parserResult($documentos);
    }
}
