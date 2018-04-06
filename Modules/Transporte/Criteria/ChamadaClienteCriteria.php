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
            ->join('users', 'transporte_chamadas.cliente_id', 'users.id')
            ->join('pessoas', 'users.pessoa_id', 'pessoas.id')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->where('cliente_id', $this->id)
            ->select(array_merge($this->defaultTable));
    }
}
