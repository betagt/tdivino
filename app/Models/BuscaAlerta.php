<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Portal\Models\BuscaAlerta
 *
 * @property int $id
 * @property int $user_id
 * @property string $url
 * @property string $titulo
 * @property string $nome
 * @property bool $ativar_alarme
 * @property string $email
 * @property string $tipo_frequencia
 * @property int $horario
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereTitulo($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereNome($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereAtivarAlarme($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereTipoFrequencia($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereHorario($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Portal\Models\BuscaAlerta whereDeletedAt($value)
 * @mixin \Eloquent
 */
class BuscaAlerta extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

}
