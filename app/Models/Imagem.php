<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;
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

}
