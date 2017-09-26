<?php

namespace Modules\Plano\Presenters;

use Modules\Plano\Transformers\PlanoContratacaoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PlanoContratacaoPresenter
 *
 * @package namespace Modules\Plano\Presenters;
 */
class PlanoContratacaoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PlanoContratacaoTransformer();
    }
}
