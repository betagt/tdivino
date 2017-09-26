<?php

namespace Modules\Plano\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Modules\Plano\Criteria\PlanoCidadesCriteria;
use Modules\Plano\Criteria\PlanoPrecoCriteria;
use Modules\Plano\Criteria\PlanoStatusCriteria;
use Portal\Criteria\OrderCriteria;
use Modules\Plano\Criteria\PlanoCriteria;
use Portal\Http\Controllers\BaseController;
use Modules\Plano\Http\Requests\PlanoRequest;
use Modules\Plano\Http\Requests\PlanoTabelaPrecoRequest;
use Modules\Plano\Repositories\PlanoRepository;
use Modules\Plano\Repositories\PlanoTabelaPrecoRepository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Plano de Anúncio - Backend
 *
 * *Essa API é responsável pelo gerenciamento de planos de anúncio no Modules\Plano qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 * Class PlanoController
 * @package Modules\Plano\Http\Controllers\Api
 */
class PlanoController extends BaseController
{
    /**
     * @var PlanoRepository
     */
    private $planoRepository;
    /**
     * @var PlanoTabelaPrecoRepository
     */
    private $planoTabelaPrecoRepository;

    public function __construct(
        PlanoRepository $planoRepository,
        PlanoTabelaPrecoRepository $planoTabelaPrecoRepository)
    {
        $this->planoRepository = $planoRepository;
        $this->planoTabelaPrecoRepository = $planoTabelaPrecoRepository;
        parent::__construct($planoRepository,PlanoCriteria::class);
    }
    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new PlanoRequest())->rules();
        return $this->validator;
    }

    /**
     * Consulta  por ID
     *
     * Endpoint para consultar passando o ID como parametro
     *
     * @param $id
     * @return retorna um registro
     */
    public function showByCidadeEstado($estadoId, $cidadeId){
        try{
            return $this->planoRepository
                ->pushCriteria(new PlanoCidadesCriteria($estadoId, $cidadeId))
                ->pushCriteria(new PlanoStatusCriteria())
                ->all();
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }


    /**
     * Cadastrar Tabela Preço
     *
     * Endpoint para cadastrar tabela de preço de plano
     *
     * @param PlanoTabelaPrecoRequest $request
     * @return retorna um registro criado
     */
    public function storeTabelaPreco(PlanoTabelaPrecoRequest $request){
        try{
            return $this->planoTabelaPrecoRepository->create($request->all());
        }catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (QueryException $e ){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.duplicate'));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    /**
     * Alterar Tabela de Preço
     *
     * Endpoint para alterar tabela de preço
     *
     * @param PlanoRequest $request
     * @return retorna registro alterado
     */
    public function updateTabelaPreco($id, Request $request){
        $data = $request->all();
        \Validator::make($data, (new PlanoTabelaPrecoRequest())->rules($id, $data))->validate();
        try{
            return $this->planoTabelaPrecoRepository->update($data, $id);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (QueryException $e ){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.duplicate'));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    /**
     * Consultar
     *
     *
     * Endpoint para consultar todos os Anuncio cadastrados
     *
     * Nessa consulta pode ser aplicado os seguintes filtros:
     *
     *  - Consultar Normal:
     *   <br> - Não passar parametros
     *
     *  - Consultar por Cidade:
     *   <br> - ?consulta={"filtro": {"estados.uf": "TO", "cidades.titulo" : "Palmas"}}
     */
    public function indexTabelaPreco($plano, Request $request){
        $request->merge(['plano'=> $plano]);

        try{
            return $this->planoTabelaPrecoRepository
                ->pushCriteria(new PlanoPrecoCriteria($request))
                ->pushCriteria(new OrderCriteria($request))
                ->paginate(self::$_PAGINATION_COUNT);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    /**
     * Consultar
     *
     *
     * Endpoint para consultar todos os Anuncio cadastrados
     *
     * Nessa consulta pode ser aplicado os seguintes filtros:
     *
     *  - Consultar Normal:
     *   <br> - Não passar parametros
     *
     *  - Consultar por Cidade:
     *   <br> - ?consulta={"filtro": {"estados.uf": "TO", "cidades.titulo" : "Palmas"}}
     */
    public function showTabelaPreco($id){
        try{
            return $this->planoTabelaPrecoRepository->find($id);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    /**
     * Deletar Tabela de Preço
     *
     * Endpoint para deletar tabela de preço passando o ID
     */
    public function destroyTabelaPreco($id){
        try{
            $this->planoTabelaPrecoRepository->delete($id);
            return parent::responseSuccess(parent::HTTP_CODE_OK, parent::MSG_REGISTRO_EXCLUIDO);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    public function excluirPreco(Request $request)
    {
        $data = $request->all();
        \Validator::make($data, [
            'ids'=>'array|required'
        ])->validate();

        try{
            app($this->planoTabelaPrecoRepository->model())->destroy($data['ids']);
            return self::responseSuccess(self::HTTP_CODE_OK, self::MSG_REGISTRO_EXCLUIDO);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }
}
















