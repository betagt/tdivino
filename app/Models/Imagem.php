<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;
use Modules\Core\Repositories\UserRepository;
use Modules\Transporte\Models\Documento;
use Modules\Transporte\Models\Veiculo;
use Modules\Transporte\Repositories\DocumentoRepository;
use Modules\Transporte\Repositories\VeiculoRepository;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Imagem extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'img',
        'principal',
        'prioridade',
        'imagemtable_id',
        'imagemtable_type',
    ];

    public static $tamanhos = [
        'anuncio'=>[
            'img_135_100'=>[
                'w'=>135,
                'h'=>135,
            ],
            'img_180_160'=>[
                'w'=>180,
                'h'=>160,
            ],
            'img_180_135'=>[
                'w'=>180,
                'h'=>135,
            ],
            'img_230_160'=>[
                'w'=>180,
                'h'=>160,
            ],
            'img_280_160'=>[
                'w'=>700,
                'h'=>525,
            ],
            'img_700_525'=>[
                'w'=>700,
                'h'=>525,
            ],
        ],
        'user'=>[
            'img_65_65'=>[
                'w'=>135,
                'h'=>135,
            ],
            'img_180_180'=>[
                'w'=>180,
                'h'=>180,
            ],
        ]
    ];

    protected static function boot()
    {
        parent::boot();
        $ativar = function ($query){
            if($query->documentotable_type == Veiculo::class){
                app(VeiculoRepository::class)->habilitarDesabilitar($query->documentotable_id);
            }
            if($query->documentotable_type == User::class){
                app(UserRepository::class)->bloquear($query->documentotable_id)->habilitarDesabilitar($query->documentotable_id);
            }
        };
        self::creating(function ($query) use ($ativar){
            if($query->imagemtable_type == Documento::class){
                $documento = app(DocumentoRepository::class)->skipPresenter(true)->find($query->imagemtable_id);
                $ativar($documento);
            }
        });
        self::updating(function ($query) use ($ativar){
            if($query->imagemtable_type == Documento::class){
                $documento = app(DocumentoRepository::class)->skipPresenter(true)->find($query->imagemtable_id);
                $ativar($documento);
            }
        });
    }

}
