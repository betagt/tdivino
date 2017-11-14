<?php

namespace Portal\Transformers;

use League\Fractal\TransformerAbstract;
use Portal\Models\Configuracao;

/**
 * Class ConfiguracaoTransformer
 * @package namespace Portal\Transformers;
 */
class ConfiguracaoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Configuracao entity
     * @param \Configuracao $model
     *
     * @return array
     */
    public function transform(Configuracao $model)
    {
        return [
            'id' => (int)$model->id,
            'titulo' => $model->titulo,
            'email' => $model->email,
            'url_site' => $model->url_site,
            'telefone' => $model->telefone,
            'horario_atendimento' => $model->horario_atendimento,
            'endereco' => $model->endereco,
            'rodape' => $model->rodape,
            'facebook' => $model->facebook,
            'twitter' => $model->twitter,
            'google_plus' => $model->google_plus,
            'youtube' => $model->youtube,
            'instagram' => $model->instagram,
            'palavra_chave' => $model->palavra_chave,
            'descricao_site' => $model->descricao_site,
            'og_tipo_app' => $model->og_tipo_app,
            'og_titulo_site' => $model->og_titulo_site,
            'od_url_site' => $model->od_url_site,
            'od_autor_site' => $model->od_autor_site,
            'facebook_id' => $model->facebook_id,
            'token' => $model->token,
            'analytcs_code' => $model->analytcs_code,
            'gasolina_km' => (double)$model->gasolina_km,
            'vlbas' => (double)$model->vlbas,
            'vlkm' => (double)$model->vlkm,
            'vlmin' => (double)$model->vlmin,
            'vlsegp' => (double)$model->vlsegp,
            'vlkmr' => (double)$model->vlkmr,
            'nmkm' => (double)$model->nmkm,
            'nmmin' => (double)$model->nmmin,
            'pkmm' => (double)$model->pkmm,
            'ptxoper' => (double)$model->ptxoper,
            'bonusm' => (double)$model->bonusm,
            'vltgo' => (double)$model->vltgo,
            'vlapseg' => (double)$model->vlapseg,
            'vlbonusp' => (double)$model->vlbonusp,
            'pbonusp' => (double)$model->pbonusp

        ];
    }


}
