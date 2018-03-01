<?php

namespace Modules\Core\Http\Controllers\Api\Admin;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Lcobucci\JWT\Parser;
use Modules\Core\Criteria\UserAgenciaReguladoraCriteria;
use Modules\Core\Criteria\UserCriteria;
use Modules\Core\Models\Pessoa;
use Modules\Localidade\Models\Endereco;
use Modules\Transporte\Services\DocumentoService;
use Portal\Criteria\OrderCriteria;
use Portal\Http\Controllers\BaseController;
use Modules\Core\Http\Requests\UserChangePasswordRequest;
use Modules\Core\Http\Requests\UserRequest;
use Modules\Core\Http\Requests\UserResetPasswordRequest;
use Modules\Core\Http\Requests\UserResetSendEmailRequest;
use Modules\Core\Models\User;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Services\ImageUploadService;
use Prettus\Repository\Exceptions\RepositoryException;
use Validator;

/**
 * @resource API Usuário - Backend
 *
 * Essa API é responsável pelo gerenciamento de Usuários no portal qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class UserController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    private $passwordBroker;
    /**
     * @var ImageUploadService
     */
    private $imageUploadService;
    /**
     * @var DocumentoService
     */
    private $documentoService;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     * @param PasswordBroker $passwordBroker
     */
    public function __construct(
        UserRepository $userRepository,
        PasswordBroker $passwordBroker,
        DocumentoService $documentoService,
        ImageUploadService $imageUploadService)
    {
        parent::__construct($userRepository, UserCriteria::class);
        $this->userRepository = $userRepository;
        $this->passwordBroker = $passwordBroker;
        $this->setPathFile(public_path('arquivos/img/user'));
        $this->imageUploadService = $imageUploadService;
        $this->documentoService = $documentoService;
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new UserRequest())->rules();
        return $this->validator;
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
    public function selectList($like){
        try{
            return $this->userRepository->parserResult(app($this->userRepository->model())->where(function ($query) use($like) {
                $query->orWhere('name', 'ilike', "%".$like."%");
                //$query->orWhere('cpf_cnpj', 'ilike', "%".$like."%");
                $query->orWhere('email', $like);
            })->limit(100)->get());
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

    public function deviceRegister(Request $request){
        $data = $request->only(['device_uuid']);
        \Validator::make($data, [
            'device_uuid' => 'required|string',
        ])->validate();
        try{
            $usuario = $this->getUser();
            $usuario->device_uuid = $data['device_uuid'];
            $usuario->save();
            return parent::responseSuccess(parent::HTTP_CODE_OK, "dispositivo redistrado com sucesso");
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    /**
     * Cadastrar
     *
     * Endpoint para cadastrar
     *
     * @param Request $request
     * @return retorna um registro criado
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if(isset($data['pessoa']['data_nascimento']))
            $data['pessoa']['data_nascimento'] = implode('-', array_reverse(explode('/', $data['pessoa']['data_nascimento'])));
        $validator = array_merge($this->getValidator(), [
            'pessoa.cpf_cnpj' => 'required|cpf_validator|unique:pessoas,cpf_cnpj',
            'pessoa.data_nascimento' => 'required|date',
            /*'pessoa.rg' => 'required',
            'pessoa.orgao_emissor' => 'required',*/
            'pessoa.escolaridade' => 'required',
            'pessoa.sexo' => 'required|integer|in:1,2',
            'pessoa.estado_civil' => 'required',
		]);
        \Validator::make($data, $validator)->validate();
        try {
			\DB::beginTransaction();
			if(!isset($data['status']))
                $data['status'] = User::INATIVO;
			$user = $this->userRepository->skipPresenter(true)->create($data);
			$documento = $user->documentos();
			if(isset($data['documentos'])){
				foreach ($data['documentos'] as $doc){
					$this->documentoService->cadastrarDocumento($doc, $documento);
				}
			}
            //event(new Registered($user));
			if(is_null($user->pessoa)){
				$pessoa = Pessoa::create($data['pessoa']);
				$user->pessoa_id = $pessoa->id;
				$user->save();
			}else{
				$user->pessoa()->update($data['pessoa']);
			}
			if(isset($data['perfil'])){
                switch ($data['perfil']){
                    case 'fornecedor':
                        $user->assignRole('fornecedor');
                        break;
                    case 'cliente':
                        $user->assignRole('cliente');
                        break;
                }
            }else{
                $user->assignRole('fornecedor');
            }
			if (isset($data['endereco'])) {
				$user->endereco()->save(Endereco::create($data['endereco']));
			}
			if (isset($data['telefone'])) {
				foreach ($data['telefone']['ddd'] as $key => $ddd) {
					$user->telefones()->create([
						'ddd' => $ddd,
						'numero' => $data['telefone']['numero'][$key],
						'principal' => $data['telefone']['principal'][$key],
						'tipo' => $data['telefone']['tipo'][$key],
					]);
				}
			}
			\DB::commit();
            return $this->userRepository->skipPresenter(false)->find($user->id);
        } catch (ModelNotFoundException $e) {
			\DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (RepositoryException $e) {
			\DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (\Exception $e) {
			\DB::rollBack();
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        }
    }

    /**
     * Cadastrar
     *
     * Endpoint para cadastrar
     *
     * @param Request $request
     * @return retorna um registro criado
     */
    public function cadastrar(Request $request)
    {
        $request->merge(['email_alternativo'=>$request->get('email')]);
        $request->merge(['remember_token' => str_random(10)]);
        $request->merge(['status'=>User::ATIVO]);
        $data = $request->only([
            'name',
            'email',
            'password',
            'cpf_cnpj',
            'email_alternativo',
            'data_nascimento',
            'sexo',
            'chk_newsletter',
            'ddd',
            'numero',
            'aceita_termos',
            'status',
        ]);
        \Validator::make($data, [
            'name'=>'required|min:3|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:3',
            'cpf_cnpj'=>'required|cpf_validator|min:3|unique:pessoas,cpf_cnpj',
            'email_alternativo'     => 'nullable|email',
            'data_nascimento'       => 'date|nullable',
            'sexo'                  => 'integer|in:1,2|nullable',
            'chk_newsletter'        => 'boolean|nullable',
            'ddd'        => 'required|numeric|nullable',
            'numero'        => 'required|numeric|nullable',
            'aceita_termos'        => 'required|boolean',
        ])->validate();
        try {
            \DB::beginTransaction();
            $user = $this->userRepository->skipPresenter(true)->create($data);
            $user->assignRole('fornecedor');
            if(!empty($data['ddd']) && !empty($data['numero'])){
                if(!is_null($user->telefone)){
                    $user->telefone->ddd = $data['ddd'];
                    $user->telefone->numero = $data['numero'];
                    $user->telefone->save();
                }else{
                    $data['principal'] = true;
                    $data['tipo'] = 'celular';
                    /*$data['telefonetable_id'] = $user->id;
                    $data['telefonetable_type'] = User::class;*/
                    $user->telefone()->create($data);
                }
            }
            $user->pessoa()->create([
                'cpf_cnpj'=>$data['cpf_cnpj']
            ]);
            \DB::commit();
            event(new Registered($user));
            return $this->userRepository->skipPresenter(false)->find($user->id);
        } catch (ModelNotFoundException $e) {
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (RepositoryException $e) {
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (\Exception $e) {
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        }
    }

    /**
     * Alterar
     *
     * Endpoint para alterar
     *
     * @param Request $request
     * @param $id
     * @return retorna registro alterado
     */
    public function updateCurrentUser(Request $request)
    {
        $id = $request->user()->id;
        $data = $request->all();
        \Validator::make($data, $this->getValidator($id))->validate();
        try {
            return $this->userRepository->update($request->all(), $id);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code' => $e->getCode(), 'line' => $e->getLine()]));
        }
    }

    /**
     * Alterar
     *
     * Endpoint para alterar
     *
     * @param Request $request
     * @param $id
     * @return retorna registro alterado
     */
    public function update(Request $request, $id){
        $data = $request->all();
        if(isset($data['pessoa']['data_nascimento']) and !is_null($data['pessoa']['data_nascimento']))
			$data['pessoa']['data_nascimento'] = implode('-', array_reverse(explode('/', $data['pessoa']['data_nascimento'])));

        $validator = array_merge($this->getValidator($id), [
			'pessoa.cpf_cnpj' => 'required|cpf_validator|unique:pessoas,cpf_cnpj',
			'pessoa.data_nascimento' => 'required|date',
			/*'pessoa.rg' => 'required',
			'pessoa.orgao_emissor' => 'required',*/
			'pessoa.escolaridade' => 'required',
			'pessoa.sexo' => 'required|integer|in:1,2',
			'pessoa.estado_civil' => 'required',

            'endereco.estado_id' => 'required|exists:estados,id',
            'endereco.cidade_id' => 'required|exists:cidades,id',
            'endereco.cep' => 'required',
            'endereco.numero' => 'required',
            'endereco.endereco' => 'required',
		]);
        \Validator::make($data, $validator)->validate();
        try{
            \DB::beginTransaction();
            if(is_null($data['password']))unset($data['password']);
            if(is_null($data['password_confirmation']))unset($data['password_confirmation']);
            $user = $this->userRepository->skipPresenter(true)->update($data,$id);
            $documento = $user->documentos();
            foreach ($data['documentos'] as $doc){
                $this->documentoService->cadastrarDocumento($doc, $documento);
            }
			if(is_null($user->pessoa)){
                $pessoa = Pessoa::create($data['pessoa']);
                $user->pessoa_id = $pessoa->id;
                $user->save();
			}else{
                $user->pessoa()->update($data['pessoa']);
			}
			if(isset($data['perfil'])){
                $user->revokeAllRoles();
                switch ($data['perfil']){
                    case 'fornecedor':
                        $user->assignRole('fornecedor');
                        break;
                    case 'cliente':
                        $user->assignRole('cliente');
                        break;
                }
            }
            if (isset($data['endereco'])) {
			    if(isset($data['endereco']['id']) && $data['endereco']['id']){
                    $model = Endereco::findOrFail($data['endereco']['id']);
                    $model->fill($data['endereco']);
                    $model->save();
                }else{
                    $user->endereco()->save(Endereco::create($data['endereco']));
                }
            }
            if (isset($data['telefone'])) {
                foreach ($data['telefone']['ddd'] as $key => $ddd) {
                    $id_telecone = $data['telefone']['id'][$key];
                    if(is_null($ddd)){
                        continue;
                    }
                    if($id_telecone){
                        $user->telefones()->update([
                            'ddd' => $ddd,
                            'numero' => $data['telefone']['numero'][$key],
                            'principal' => $data['telefone']['principal'][$key],
                            'tipo' => $data['telefone']['tipo'][$key],
                        ],$id_telecone);
                    }else{
                        $user->telefones()->create([
                            'ddd' => $ddd,
                            'numero' => $data['telefone']['numero'][$key],
                            'principal' => $data['telefone']['principal'][$key],
                            'tipo' => $data['telefone']['tipo'][$key],
                        ]);
                    }
                }
            }
            $result = $this->userRepository->skipPresenter(false)->find($user->id);
            \DB::commit();
            return  $result;
        }catch (ModelNotFoundException $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            \DB::rollBack();
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    /**
     * Alterar
     *
     * Endpoint para alterar
     *
     * @param Request $request
     * @param $id
     * @return retorna registro alterado
     */
    public function updatePessoa(Request $request)
    {
        $user = $request->user();
        $data = $request->only([
            'cpf_cnpj', 'nec_especial', 'data_nascimento', 'rg', 'orgao_emissor', 'escolaridade', 'sexo', 'estado_civil', 'fantasia', 'contato','tipo_sanguineo',
        ]);
        \Validator::make($data, [
            'sexo'                  => 'integer|in:1,2|nullable',
            'data_nascimento'       => 'date|nullable',
        ])->validate();
        try {
            if(is_null($user->pessoa)){
                $pessoa = Pessoa::create($data);
                $user->pessoa_id = $pessoa->id;
                $user->save();
            }else{
                $user->pessoa()->update($data);
            }
            return $this->userRepository->find($user->id);
        } catch (ModelNotFoundException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return self::responseError(self::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Alterar Imagem Usuário logado
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function changeImage(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'imagem' => [
                'required',
                'image',
                'mimes:jpg,jpeg,bmp,png'
            ]
        ])->validate();
        try {
            $this->imageUploadService->upload('imagem', $this->getPathFile(), $data);
            return $this->userRepository->update($data, $request->user()->id);
        } catch (ModelNotFoundException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Alterar Imagem Administrativo
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function changeImageAdmin(Request $request, $id)
    {
        $data = $request->all();
        Validator::make($data, [
            'imagem' => [
                'required',
                'image',
                'mimes:jpg,jpeg,bmp,png'
            ]
        ])->validate();
        try {
            $this->imageUploadService->upload('imagem', $this->getPathFile(), $data);
            return $this->userRepository->update($data, $id);
        } catch (ModelNotFoundException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Consultar Perfil Usuário
     *
     * Endpoint para consultar perfil do usuário passando o ID como parametro
     *
     * @param $id
     * @return mixed
     */
    public function myProfile(Request $request)
    {
        $id = $request->user()->id;
        try {
            return $this->userRepository->find($id);
        } catch (ModelNotFoundException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Consultar Perfil Usuário
     *
     * Endpoint para consultar perfil do usuário passando o ID como parametro
     *
     * @param $id
     * @return mixed
     */
    public function userPosicao(Request $request)
    {
        $data = $request->only(['lat','lng']);
        $this->getUser()->lat = $data['lat'];
        $this->getUser()->lng = $data['lng'];
        $this->getUser()->save();
        try {
            return $this->userRepository->find($this->getUserId());
        } catch (ModelNotFoundException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (RepositoryException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Solicitar Nova Senha
     *
     * Enviar email com link para usuário recuperar senha
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function solicitarNovaSenha(UserResetSendEmailRequest $request)
    {
        $response = $this->passwordBroker->sendResetLink($request->only('email'), function ($m) {
            $m->subject($this->getEmailSubject());
        });

        switch ($response) {
            case PasswordBroker::RESET_LINK_SENT:
                return parent::responseSuccess(parent::HTTP_CODE_OK, "O link de recuperação de senha foi enviado para seu endereço de e-mail");
            case PasswordBroker::INVALID_USER:
                return parent::responseError(parent::HTTP_CODE_NOT_FOUND, "Não é possível encontrar um usuário com esse endereço de e-mail");
        }
    }

    /**
     * Criar Nova Senha
     *
     * Enviar dados para criar a nova senha solicitada pelo usuário
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function criarNovaSenha(UserResetPasswordRequest $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->passwordBroker->reset($credentials, function ($user, $password) {
            $user->forceFill([
                'password' => $password,
                'remember_token' => Str::random(60),
            ])->save();
        });

        switch ($response) {
            case PasswordBroker::PASSWORD_RESET:
                return parent::responseSuccess(parent::HTTP_CODE_OK, "Senha alterada com sucesso.");
            case PasswordBroker::INVALID_TOKEN:
                return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, "O Token de reinicialização inválida ou já expirou.");
            case PasswordBroker::INVALID_USER:
                return parent::responseError(parent::HTTP_CODE_NOT_FOUND, "Não é possível encontrar um usuário com esse endereço de e-mail");
            default:
                return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, "Erro inesperado.");
        }
    }

    /**
     * Alterar Senha
     *
     * Enviar dados para alterar a senha
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function alterarSenha(UserChangePasswordRequest $request)
    {
        $user = $request->user();
        if (password_verify($request->get('old_password'), $user->password)) {
            $this->userRepository->update(['password' => $request->get('new_password')], $user->id);
            return parent::responseSuccess(parent::HTTP_CODE_OK, "Senha alterada com sucesso.");
        }
        return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, "A senha atual não confere.");
    }

    /**
     * Deletar Usuário
     */
    public function destroy($id)
    {
        try {
            $this->userRepository->delete($id);
            return parent::responseSuccess(parent::HTTP_CODE_OK, parent::MSG_REGISTRO_EXCLUIDO);
        } catch (ModelNotFoundException $e) {
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        } catch (\Exception $e) {
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    public function logout(Request $request)
    {

        $value = $request->bearerToken();
        $id = (new Parser())->parse($value)->getHeader('jti');
        \DB::table('oauth_access_tokens')
            ->where('id', '=', $id)
            ->update(['revoked' => true]);

        $json = [
            'success' => true,
            'code' => 200,
            'message' => 'You are Logged out.',
        ];
        return response()->json($json, '200');
    }


    public function listagemFornecedores(Request $request){
		try{
			return $this->defaultRepository
				->pushCriteria(new UserAgenciaReguladoraCriteria($request))
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
     * Consulta  por ID
     *
     * Endpoint para consultar passando o ID como parametro
     *
     * @param $id
     * @return retorna um registro
     */
    public function vizualizarFornecedor($id){
        try{
            return $this->userRepository->visualizarFornecedor($id);
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
}
