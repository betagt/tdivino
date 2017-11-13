<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\GeoPosicaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GeoPosicaoPresenter
 *
 * @package namespace Portal\Presenters;
 */
class GeoPosicaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GeoPosicaoTransformer();
    }
}
