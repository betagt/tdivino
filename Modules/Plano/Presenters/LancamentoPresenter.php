<?php

namespace Modules\Plano\Presenters;

use Modules\Plano\Transformers\LancamentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class LancamentoPresenter
 *
 * @package namespace Portal\Presenters;
 */
class LancamentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new LancamentoTransformer();
    }
}
