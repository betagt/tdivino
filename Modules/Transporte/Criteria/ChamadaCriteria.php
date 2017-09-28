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
class ChamadaCriteria extends BaseCriteria
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
    protected $filterCriteria = [];
}
