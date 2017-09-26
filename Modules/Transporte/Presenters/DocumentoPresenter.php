<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\DocumentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DocumentoPresenter
 *
 * @package namespace Portal\Presenters;
 */
class DocumentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DocumentoTransformer();
    }
}
