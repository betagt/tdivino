<?php

namespace Modules\Plano\Presenters;

use Modules\Plano\Transformers\FormaPagamentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FormaPagamentoPresenter
 *
 * @package namespace Modules\Plano\Presenters;
 */
class FormaPagamentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FormaPagamentoTransformer();
    }
}
