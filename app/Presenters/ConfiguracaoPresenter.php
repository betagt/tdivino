<?php

namespace Portal\Presenters;

use Portal\Transformers\ConfiguracaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ConfiguracaoPresenter
 *
 * @package namespace Portal\Presenters;
 */
class ConfiguracaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ConfiguracaoTransformer();
    }
}
