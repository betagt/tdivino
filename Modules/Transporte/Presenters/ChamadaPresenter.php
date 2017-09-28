<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\ChamadaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ChamadaPresenter
 *
 * @package namespace Portal\Presenters;
 */
class ChamadaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ChamadaTransformer();
    }
}
