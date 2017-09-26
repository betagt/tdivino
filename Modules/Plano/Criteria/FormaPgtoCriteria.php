<?php

namespace Modules\Plano\Criteria;

use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FormaPgtoCriteria
 * @package namespace Modules\Plano\Criteria;
 */
class FormaPgtoCriteria extends BaseCriteria implements CriteriaInterface
{
    protected $filterCriteria = [
        'forma_pagamentos.id'         =>'=',
        'forma_pagamentos.nome'       =>'ilike',
        'forma_pagamentos.taxa'       =>'=',
        'forma_pagamentos.status'       =>'=',
        'forma_pagamentos.created_at' =>'between',
        'forma_pagamentos.updated_at' =>'between',
    ];
}
