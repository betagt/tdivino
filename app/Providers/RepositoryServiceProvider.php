<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 30/12/2016
 * Time: 10:44
 */

namespace Portal\Providers;



use Portal\Repositories\BuscaAlertaRepository;
use Portal\Repositories\BuscaAlertaRepositoryEloquent;
use Portal\Repositories\ClientRepository;
use Portal\Repositories\ClientRepositoryEloquent;
use Portal\Repositories\ConfiguracaoRepository;
use Portal\Repositories\ConfiguracaoRepositoryEloquent;
use Portal\Repositories\ImagemRepository;
use Portal\Repositories\ImagemRepositoryEloquent;
use Portal\Repositories\MensagemFinanceiroRepository;
use Portal\Repositories\MensagemFinanceiroRepositoryEloquent;
use Portal\Repositories\PaginaRepository;
use Portal\Repositories\PaginaRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

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
            ConfiguracaoRepository::class,
            ConfiguracaoRepositoryEloquent::class
        );
        $this->app->bind(
            PaginaRepository::class,
            PaginaRepositoryEloquent::class
        );
        $this->app->bind(
            ImagemRepository::class,
            ImagemRepositoryEloquent::class
        );

        $this->app->bind(
            BuscaAlertaRepository::class,
            BuscaAlertaRepositoryEloquent::class
        );
        $this->app->bind(
            MensagemFinanceiroRepository::class,
            MensagemFinanceiroRepositoryEloquent::class
        );

        $this->app->bind(
            ClientRepository::class,
            ClientRepositoryEloquent::class
        );

    }
}