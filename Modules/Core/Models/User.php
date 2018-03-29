<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kodeine\Acl\Traits\HasRole;
use Laravel\Passport\HasApiTokens;
use Modules\Core\Events\AtualizaDados;
use Modules\Core\Repositories\UserRepository;
use Modules\Localidade\Models\Endereco;
use Modules\Localidade\Models\Telefone;
use Modules\Transporte\Models\Chamada;
use Modules\Transporte\Models\Conta;
use Modules\Transporte\Models\Documento;
use Modules\Transporte\Models\Veiculo;
use Modules\Transporte\Repositories\TipoDocumentoRepository;
use Modules\Transporte\Repositories\VeiculoRepository;
use OwenIt\Auditing\Auditable;
use Portal\Notifications\PasswordReset;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class User extends Authenticatable implements Transformable
{
    use Notifiable, HasApiTokens, SoftDeletes, TransformableTrait, HasRole, Auditable;


    const INATIVO = "inativo";
    const ATIVO = "ativo";
    const BLOQUEADO = "bloqueado";

    const CLIENTE = "cliente";
    const FORNECEDOR = "fornecedor";
    const MOTORISTA  = "motorista";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pagina_user',
        'email_alternativo',
        'imagem',
        'chk_newsletter',
        'status',
        'remember_token',
        'cep',
        'pessoa_id',
        'disponivel',
        'lat',
        'lng',
        'documentos_validate',
		'device_uuid',
        'aceita_termos',
        'codigo',
        'incicacao',
        'habilitado',
        'avaliacao',
    ];

    public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->attributes['codigo'] = substr(md5(time()), 0, 6);

	}

	protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        $ativar = function ($query){
            //TODO criar eventos para para esse tipo de ação.
            if(!is_null($query->id) && in_array(User::FORNECEDOR, $query->getRoles())){
                $validado = app(TipoDocumentoRepository::class)->validadeUser($query->id);
                $verificacao = ((!$validado['habilitado'] && is_null($query->veiculoAtivo)) || ($validado['habilitado'] && is_null($query->veiculoAtivo)));
                $query->status = $verificacao?User::BLOQUEADO:User::ATIVO;
                $query->habilitado = !$verificacao;
                return $query;
            }
        };
        self::creating(function ($query) use ($ativar){
            return $ativar($query);
        });
        self::updating(function ($query) use ($ativar){
            if(!is_null($query->device_uuid))
                event(new AtualizaDados($query->device_uuid, 'Seu cadastro foi atualizardo!'));
            return $ativar($query);
        });
        self::saving(function ($query) use ($ativar){
            return $ativar($query);
        });
    }

    public function findForPassport($username)
    {
        $return = $this->where('email', $username)->first();

        if(is_null($return)){
            return false;
        }

        if ($return->status == self::INATIVO) {
            return false;
        }

        return $return;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public static $_SEXO = [
        1 => 'masculino',
        2 => 'feminino'
    ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setCepAttribute($value)
    {
        if ($value)
            $this->attributes['cep'] = preg_replace('([\.\-\/])', '', $value);
    }
    public function setEmailAttribute($value)
    {
        if ($value)
            $this->attributes['email'] = strtolower($value);
    }

    public function setEmailAlternativoAttribute($value)
    {
        if ($value)
            $this->attributes['email_alternativo'] = strtolower($value);
    }

    public function pessoa(){
        return $this->belongsTo(Pessoa::class);
    }

    public function contas(){
        return $this->hasMany(Conta::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
    }

    public function endereco()
    {
        return $this->morphOne(Endereco::class, 'enderecotable');
    }

    public function telefones()
    {
        return $this->morphMany(Telefone::class, 'telefonetable');
    }

    public function telefone()
    {
        return $this->morphOne(Telefone::class, 'telefonetable')->where('principal', '=', true);
    }

    public function return_roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function documentos()
    {
        return $this->morphMany(Documento::class, 'documentotable')
            ->join('transporte_tipo_documentos','transporte_tipo_documentos.id','transporte_documentos.transporte_tipo_documento_id')
            ->orderBy('transporte_tipo_documentos.nome','ASC')
            ->select(['transporte_documentos.*']);
    }

    public function chamadas_cliente(){
		return $this->hasMany(Chamada::class, 'client_id');
	}

	public function chamadas_fornecedor(){
		return $this->hasMany(Chamada::class, 'fornecedor_id');
	}

    public function veiculoAtivo(){
        return $this->hasOne(Veiculo::class, 'user_id')->where('status', '=', Veiculo::ACEITO);
    }

    public function documentacao(){

    }

}
