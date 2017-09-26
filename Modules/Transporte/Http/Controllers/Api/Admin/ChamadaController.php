<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Transporte\Criteria\ChamadaCriteria;
use Modules\Transporte\Http\Requests\ChamadaRequest;
use Modules\Transporte\Repositories\ChamadaRepository;
use Portal\Http\Controllers\BaseController;

use Modules\Transporte\Models\Chamada;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Usuários no portal qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class ChamadaController extends BaseController
{
    /**
     * @var ChamadaRepository
     */
    private $chamadaRepository;

    public function __construct(
        ChamadaRepository $chamadaRepository)
    {
        parent::__construct($chamadaRepository, ChamadaCriteria::class);
        $this->chamadaRepository = $chamadaRepository;
    }


    public function getValidator($id = null)
    {
        $this->validator = (new ChamadaRequest())->rules($id);
        return $this->validator;
    }

    /**8
     * Iniciar a chamada
     *
     *
     * Endpoint para dar inicio ao serviço de chamada de taxi
     *@return mixed
     */
    function iniciarChamada(Request $request){
        $position = $request->only(['lat', 'lng']);
        $data = [];
        $data['client_id'] = $this->getUserId();
        $data['tipo'] = Chamada::TIPO_SOLICITACAO;
        $data['timedown'] = Carbon::now()->addMinute(5);
        //calculo da distancia
        //posição de inicio
        //posição final
        //posição que o taxista está
        //TODO aqui realiza o log do posicionamento usando o $position antes de salvar a chamada
        try{
            return $this->chamadaRepository->create($data);
        }catch (ModelNotFoundException $e){
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return parent::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    function iniciarIntencaoDeCompra(Request $request){
        //Todo recuerar o valor do kilometo talvez seria interessante o app carregar essas informações iniciamente.
    }



}
