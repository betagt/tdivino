<?php

namespace Modules\Transporte\Criteria;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Portal\Criteria\BaseCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class NewsletterCriteria
 * @package namespace Portal\Criteria;
 */
class ChamadaFornecedorCriteria extends BaseCriteria
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
        'users.name' => 'ilike',
        'users.email' => 'like',
        'pessoas.cpf_cnpj' => 'like',
        'roles.slug' => 'in',
        'fornecedor_id' => '='
    ];

    public function apply($model, RepositoryInterface $repository)
    {
        $model = parent::apply($model, $repository);
        return $model
            ->join('users', 'transporte_chamadas.fornecedor_id', 'users.id')
            ->join('pessoas', 'users.pessoa_id', 'pessoas.id')
            ->join('role_user', 'users.id', 'role_user.user_id')
            ->join('roles', 'roles.id', 'role_user.role_id')
            ->whereBetween('transporte_chamadas.created_at', [date('Y-m-01'), date('Y-m-t')])
            ->where('fornecedor_id', $this->id)
            ->select(array_merge($this->defaultTable));
    }
}
