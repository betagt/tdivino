<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\MarcaCarroTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MarcaCarroPresenter
 *
 * @package namespace Portal\Presenters;
 */
class MarcaCarroPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MarcaCarroTransformer();
    }
}
