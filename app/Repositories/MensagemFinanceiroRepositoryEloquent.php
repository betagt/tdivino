<?php

namespace Portal\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Portal\Repositories\MensagemFinanceiroRepository;
use Portal\Models\MensagemFinanceiro;
use Portal\Validators\MensagemFinanceiroValidator;

/**
 * Class MensagemFinanceiroRepositoryEloquent
 * @package namespace Portal\Repositories;
 */
class MensagemFinanceiroRepositoryEloquent extends BaseRepository implements MensagemFinanceiroRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MensagemFinanceiro::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
