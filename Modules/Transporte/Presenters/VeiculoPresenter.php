<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\VeiculoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class VeiculoPresenter
 *
 * @package namespace Portal\Presenters;
 */
class VeiculoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new VeiculoTransformer();
    }
}
