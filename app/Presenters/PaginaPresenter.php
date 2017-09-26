<?php

namespace Portal\Presenters;

use Portal\Transformers\PaginaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PaginaPresenter
 *
 * @package namespace Portal\Presenters;
 */
class PaginaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PaginaTransformer();
    }
}
