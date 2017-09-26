<?php
/**
 * Created by PhpStorm.
 * User: pc05
 * Date: 15/05/2017
 * Time: 17:08
 */

namespace Modules\Plano\Services;


use Illuminate\Http\Request;
use Modules\Anuncio\Models\Anuncio;
use Modules\Anuncio\Repositories\AnuncioRepository;
use Modules\Localidade\Repositories\EnderecoRepository;
use Modules\Plano\Criteria\PlanoCidadesCriteria;
use Modules\Plano\Repositories\ContratacaoFaturaRepository;
use Modules\Plano\Repositories\LancamentoRepository;
use Modules\Plano\Repositories\PlanoContratacaoRepository;
use Modules\Plano\Repositories\PlanoRepository;
use Modules\Plano\Repositories\PlanoTabelaPrecoRepository;

class PlanoContratacaoService
{
    /**
     * @var AnuncioRepository
     */
    private $anuncioRepository;

    /**
     * @var PlanoContratacaoRepository
     */
    private $planoContratacaoRepository;

    /**
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * @var PlanoRepository
     */
    private $planoRepository;

    /**
     * @var LancamentoRepository
     */
    private $repository;

    /**
     * @var ContratacaoFaturaRepository
     */
    private $contratacaoFaturaRepository;

    /**
     * @var Request
     */
    private $request;
    /**
     * @var PlanoTabelaPrecoRepository
     */
    private $planoTabelaPrecoRepository;

    public function __construct(
        AnuncioRepository $anuncioRepository,
        PlanoContratacaoRepository $planoContratacaoRepository,
        EnderecoRepository $enderecoRepository,
        PlanoRepository $planoRepository,
        PlanoTabelaPrecoRepository $planoTabelaPrecoRepository,
        LancamentoRepository $repository,
        ContratacaoFaturaRepository $contratacaoFaturaRepository,
        Request $request)
    {
        $this->anuncioRepository = $anuncioRepository;
        $this->planoContratacaoRepository = $planoContratacaoRepository;
        $this->enderecoRepository = $enderecoRepository;
        $this->planoRepository = $planoRepository;
        $this->repository = $repository;
        $this->contratacaoFaturaRepository = $contratacaoFaturaRepository;
        $this->request = $request;
        $this->planoTabelaPrecoRepository = $planoTabelaPrecoRepository;
    }

    public function updateOrCreate($data, $id=null)
    {
         \DB::beginTransaction();
         try{
             $anuncio = $this->anuncioRepository->skipPresenter(true)->find($data['contratacao']['anuncio_id']);
             $plano = $this->planoSelected($data['contratacao']['plano_id'], $anuncio->cidade_id, $anuncio->estado_id);
             $planoId = $data['contratacao']['plano_id'];
             if($id){
                 $contratacao = $this->save($id, $planoId, $data, $plano, $anuncio);
             }else{
                 $contratacao = $this->criar($planoId, $data, $plano, $anuncio);
             }
             \DB::commit();
             return ['data'=>$this->planoContratacaoRepository->parserResult($contratacao)];
         }catch(\Exception $e){
             \DB::rollback();
         }
    }
    private function save($id, $planoId, $data, $plano, $anuncio){
        $contratacao = $this->planoContratacaoRepository
            ->skipPresenter(true)->find($id);
        if($contratacao->plano_id != $planoId || ($anuncio->contratacaoAtiva->count() <= 0)) {
            $contratacao->plano_id = $planoId;
            //TODO Criar um envio de e-mail indicando a mudança de plano
            $contratacao->data_inicio = \Carbon\Carbon::now();
            $contratacao->data_fim = \Carbon\Carbon::now()->addDays($plano['dias']);
        }
        $contratacao->user_id = $data['contratacao']['user_id'];
        $contratacao->total = $plano['valor'];
        $contratacao->desconto = (double)$data['contratacao']['desconto'];
        $contratacao->save();
        $contratacao->fatura->fill($data['fatura'])->save();
        if($data['fatura']['endereco_diferente']) {
            $contratacao->endereco->fill($data['endereco'])->save();
        }
        $contratacao->anuncios()->sync([$anuncio->id]);
        return $contratacao;
    }

    private function criar($planoId, $data, $plano, $anuncio){
        $contratar = [
            'plano_id' => $planoId,
            'user_id' => $data['contratacao']['user_id'],
            'total' => $plano['valor'],'data_inicio' => \Carbon\Carbon::now(),
            'data_fim' => \Carbon\Carbon::now()->addDays($plano['dias']),
            'desconto' => $data['contratacao']['desconto'],
        ];
        $contratacao = $this->planoContratacaoRepository
            ->skipPresenter(true)
            ->create($contratar);
        $data['fatura']['plano_contratacao_id'] = $contratacao->id;
        $contratacao->anuncios()->attach($anuncio);
        $this->gerarFatura($data, $anuncio);
        //TODO Criar um envio de e-mail indicando a contratação plano
        return $contratacao;
    }

    private function planoSelected($planoId, $estadoId, $cidadeId)
    {
        $tabela = $this->planoTabelaPrecoRepository->skipPresenter(true)->findWhere([
            'plano_id' => $planoId,
            'cidade_id' => $estadoId,
            'estado_id' => $cidadeId,
        ])->first();

        $plano = $this->planoRepository
            ->skipPresenter(true)
            ->find($planoId)->toArray();

        return (is_null($tabela)) ? $plano : array_merge($plano, $tabela->toArray());
    }

    private function gerarFatura($data, Anuncio $anuncio){
        $fatura = $this->contratacaoFaturaRepository->skipPresenter(true)->create( $data['fatura']);

        if($data['fatura']['endereco_diferente']){
            $fatura->endereco()->create($data['endereco']);
        }else{
            $endereco = $anuncio->endereco->toArray();
            unset($endereco['enderecotable_id']);
            unset($endereco['enderecotable_type']);
            unset($endereco['id']);
            $fatura->endereco()->create($endereco);
        }
    }
}