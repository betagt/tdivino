<?php

namespace  Modules\Transporte\Presenters;

use  Modules\Transporte\Transformers\ModeloCarroTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ModeloCarroPresenter
 *
 * @package namespace Portal\Presenters;
 */
class ModeloCarroPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ModeloCarroTransformer();
    }
}
