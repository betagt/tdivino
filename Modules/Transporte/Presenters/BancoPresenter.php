<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\BancoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BancoPresenter
 *
 * @package namespace Portal\Presenters;
 */
class BancoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BancoTransformer();
    }
}
