<?php

namespace Modules\Core\Presenters;

use Portal\Transformers\PessoaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PessoaPresenter
 *
 * @package namespace Portal\Presenters;
 */
class PessoaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PessoaTransformer();
    }
}
