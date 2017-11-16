<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\ContaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContaPresenter
 *
 * @package namespace Portal\Presenters;
 */
class ContaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContaTransformer();
    }
}
