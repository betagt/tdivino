<?php

namespace Modules\Transporte\Repositories;

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
}
