<?php
/**
 * Created by PhpStorm.
 * User: pc05
 * Date: 12/06/2017
 * Time: 17:43
 */

namespace Portal\Services;


use Portal\Models\Configuracao;
use Portal\Repositories\ConfiguracaoRepository;

class ConfiguracaoService
{

    private $configuracaoRepository;

    /**
     * @var \Illuminate\Cache\Repository
     */
    private $cache;

    public function __construct(
        \Illuminate\Cache\Repository $cache,
        ConfiguracaoRepository $configuracaoRepository )
    {
        $this->configuracaoRepository = $configuracaoRepository;
        $this->cache = $cache;
    }

    function getConfiguracao(){
        $this->cache->forget('configuracao');
        if(!$this->cache->has('configuracao')){
            $configuracao = $this->configuracaoRepository->first();
            $this->cache->add('configuracao', $configuracao, 10);
        }
        return $this->cache->get('configuracao');
    }


}