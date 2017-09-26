<?php

namespace Portal\Presenters;

use Portal\Transformers\MensagemFinanceiroTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MensagemFinanceiroPresenter
 *
 * @package namespace Portal\Presenters;
 */
class MensagemFinanceiroPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MensagemFinanceiroTransformer();
    }
}
