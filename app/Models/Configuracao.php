<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Configuracao extends Model implements Transformable
{
    use TransformableTrait, Auditable, SoftDeletes;

    protected $fillable = [
        'titulo', 'email', 'url_site', 'telefone', 'horario_atendimento', 'endereco', 'rodape',
        'facebook', 'twitter', 'google_plus', 'youtube', 'instagram', 'palavra_chave', 'descricao_site',
        'og_tipo_app', 'og_titulo_site', 'od_url_site', 'od_autor_site', 'facebook_id', 'token', 'analytcs_code', 'gasolina_km'
    ];

    protected  $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

}
