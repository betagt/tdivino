<?php

namespace Modules\Transporte\Presenters;

use Modules\Transporte\Transformers\ServicoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ServicoPresenter
 *
 * @package namespace Portal\Presenters;
 */
class ServicoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ServicoTransformer();
    }
}
