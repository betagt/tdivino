<?php

namespace Modules\Transporte\Repositories;

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
}
