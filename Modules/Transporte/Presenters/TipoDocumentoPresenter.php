<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\TipoDocumentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class HabilidadePresenter
 *
 * @package namespace Portal\Presenters;
 */
class TipoDocumentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TipoDocumentoTransformer();
    }
}
