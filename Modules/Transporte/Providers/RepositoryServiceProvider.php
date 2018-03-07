<?php

namespace Modules\Transporte\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Transporte\Repositories\BancoRepository;
use Modules\Transporte\Repositories\BancoRepositoryEloquent;
use Modules\Transporte\Repositories\ChamadaRepository;
use Modules\Transporte\Repositories\ChamadaRepositoryEloquent;
use Modules\Transporte\Repositories\ContaRepository;
use Modules\Transporte\Repositories\ContaRepositoryEloquent;
use Modules\Transporte\Repositories\DocumentoRepository;
use Modules\Transporte\Repositories\DocumentoRepositoryEloquent;
use Modules\Transporte\Repositories\FinanceiroContaRepository;
use Modules\Transporte\Repositories\FinanceiroContaRepositoryEloquent;
use Modules\Transporte\Repositories\GeoPosicaoRepository;
use Modules\Transporte\Repositories\GeoPosicaoRepositoryEloquent;
use Modules\Transporte\Repositories\MarcaCarroRepository;
use Modules\Transporte\Repositories\MarcaCarroRepositoryEloquent;
use Modules\Transporte\Repositories\ModeloCarroRepository;
use Modules\Transporte\Repositories\ModeloCarroRepositoryEloquent;
use Modules\Transporte\Repositories\MovimentacaoRepository;
use Modules\Transporte\Repositories\MovimentacaoRepositoryEloquent;
use Modules\Transporte\Repositories\TipoDocumentoRepository;
use Modules\Transporte\Repositories\TipoDocumentoRepositoryEloquent;
use Modules\Transporte\Repositories\ServicoRepository;
use Modules\Transporte\Repositories\ServicoRepositoryEloquent;
use Modules\Transporte\Repositories\VeiculoRepository;
use Modules\Transporte\Repositories\VeiculoRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ServicoRepository::class,
            ServicoRepositoryEloquent::class
        );
        $this->app->bind(
            TipoDocumentoRepository::class,
            TipoDocumentoRepositoryEloquent::class
        );
        $this->app->bind(
            DocumentoRepository::class,
            DocumentoRepositoryEloquent::class
        );
        $this->app->bind(
            ChamadaRepository::class,
            ChamadaRepositoryEloquent::class
        );
        $this->app->bind(
            VeiculoRepository::class,
            VeiculoRepositoryEloquent::class
        );
        $this->app->bind(
            MarcaCarroRepository::class,
            MarcaCarroRepositoryEloquent::class
        );
        $this->app->bind(
            ModeloCarroRepository::class,
            ModeloCarroRepositoryEloquent::class
        );
        $this->app->bind(
            GeoPosicaoRepository::class,
            GeoPosicaoRepositoryEloquent::class
        );
        $this->app->bind(
            ContaRepository::class,
			ContaRepositoryEloquent::class
        );
        $this->app->bind(
            BancoRepository::class,
			BancoRepositoryEloquent::class
        );
        $this->app->bind(
            FinanceiroContaRepository::class,
            FinanceiroContaRepositoryEloquent::class
        );
        $this->app->bind(
            MovimentacaoRepository::class,
            MovimentacaoRepositoryEloquent::class
        );
    }
}
