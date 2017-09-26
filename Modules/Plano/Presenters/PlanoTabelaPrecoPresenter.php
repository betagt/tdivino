<?php

namespace Modules\Plano\Presenters;

use Modules\Plano\Transformers\PlanoTabelaPrecoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PlanoTabelaPrecoPresenter
 *
 * @package namespace Portal\Presenters;
 */
class PlanoTabelaPrecoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PlanoTabelaPrecoTransformer();
    }
}
