<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\MovimentacaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FinanceiroContaPresenter
 *
 * @package namespace Portal\Presenters;
 */
class MovimentacaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MovimentacaoTransformer();
    }
}
