<?php

namespace Modules\Core\Repositories;

use Illuminate\Container\Container as Application;
use Modules\Core\Models\User;
use Modules\Core\Presenters\UserPresenter;
use Modules\Transporte\Repositories\TipoDocumentoRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent
 * @package namespace Modules\Core\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{


    /**
     * @var TipoDocumentoRepository
     */
    private $documentoRepositoryEloquent;

    public function __construct(Application $app, TipoDocumentoRepository $documentoRepositoryEloquent)
    {
        parent::__construct($app);
        $this->documentoRepositoryEloquent = $documentoRepositoryEloquent;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return UserPresenter::class;
    }

    /**
     * Get all roles.
     *
     * @return array
     */
    public function getRoles(int $id)
    {
        if(!$this->skipPresenter){
            return ['data'=>$this->model->find($id)->getRoles()];
        }
        return $this->model->find($id)->getRoles();
    }

    public function getPermissions(int $id)
    {
        if(!$this->skipPresenter){
            return ['data'=>$this->model->find($id)->getPermissions()];
        }
        return $this->model->find($id)->getPermissions();
    }

    public function removePermission(string $alias, array $slugs = null)
    {
        return $this->model->removePermission($alias, $slugs);
    }

    /**
     * @param string $alias
     * @param array|null $slugs
     * @return mixed
     */
    public function addPermission(int $userId, string $alias, array $slugs = null)
    {
       return $this->model->find($userId)->addPermission($alias,$slugs);
    }

    /**
     * @param int $id
     * @param int|string|collection|array $role
     * @return mixed
     */
    public function revokeRole(int $id, $role)
    {
        return $this->model->find($id)->revokeRole($role);
    }

    /**
     * @param int $id
     * @param int|string|collection|array $role
     * @return mixed
     */
    public function revokeAllRoles(int $id)
    {
        return $this->model->find($id)->revokeAllRoles();
    }

    /**
     * Sync Role(s) To User
     *
     * You can pass an array of role objects,ids or slugs to sync them to a user.
     *
     * @param int $userId
     * @param array $roles
     * @return mixed
     */
    public function syncRoles(int $userId, $roles)
    {
        return $this->model->find($userId)->syncRoles($roles);
    }


    function visualizarFornecedor(int $id)
    {
        return $this->parserResult($this->model
            ->join('role_user','users.id','role_user.user_id')
            ->join('roles','roles.id','role_user.role_id')
            ->where('roles.slug', User::FORNECEDOR)
            ->where('users.id', $id)
            ->select(['users.*'])->first());
    }

    public function habilitarDesabilitar(int $id, $habilitado = false)
    {
        $usuario = $this->skipPresenter(true)->find($id);
        $usuario->habilitado = $habilitado;
        if(!$habilitado)
            $usuario->status = User::BLOQUEADO;
        $usuario->save();
    }

    public function bloquear(int $id)
    {
        $usuario = $this->skipPresenter(true)->find($id);
        $usuario->status = User::BLOQUEADO;
        $usuario->save();
        return $this;
    }

    public function documentosPententes(int $id){
        return $this->documentoRepositoryEloquent->validadeUser($id);
    }
}
