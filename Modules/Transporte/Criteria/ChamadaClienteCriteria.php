<?php

namespace Modules\Transporte\Criteria;

use Illuminate\Http\Request;
use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class NewsletterCriteria
 * @package namespace Portal\Criteria;
 */
class ChamadaClienteCriteria extends BaseCriteria
{
    /**
     * @var null
     */
    private $id;

    public function __construct(Request $request, $id=null)
    {
        parent::__construct($request);

        $this->id = $id;
    }

    protected $filterCriteria = [
        'cliente_id' => '='
    ];

    public function apply($model, RepositoryInterface $repository)
    {
        $model = parent::apply($model, $repository);
        return $model
            ->where('cliente_id', $this->id)
            ->select(array_merge($this->defaultTable));
    }
}
