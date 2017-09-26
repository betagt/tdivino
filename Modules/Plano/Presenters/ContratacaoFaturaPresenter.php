<?php

namespace Modules\Plano\Presenters;

use Modules\Plano\Transformers\ContratacaoFaturaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContratacaoFaturaPresenter
 *
 * @package namespace Portal\Presenters;
 */
class ContratacaoFaturaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContratacaoFaturaTransformer();
    }
}
