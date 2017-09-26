<?php

namespace Modules\Plano\Presenters;

use Modules\Plano\Transformers\PlanoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PlanoPresenter
 *
 * @package namespace Modules\Plano\Presenters;
 */
class PlanoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PlanoTransformer();
    }
}
