<?php

namespace Portal\Presenters;

use Portal\Transformers\ImagemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ImagemPresenter
 *
 * @package namespace Portal\Presenters;
 */
class ImagemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ImagemTransformer();
    }
}
