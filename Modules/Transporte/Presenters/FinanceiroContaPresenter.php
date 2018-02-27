<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\FinanceiroContaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FinanceiroContaPresenter
 *
 * @package namespace Portal\Presenters;
 */
class FinanceiroContaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FinanceiroContaTransformer();
    }
}
