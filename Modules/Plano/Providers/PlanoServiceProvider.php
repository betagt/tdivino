<?php

namespace Modules\Plano\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Plano\Repositories\ContratacaoFaturaRepository;
use Modules\Plano\Repositories\ContratacaoFaturaRepositoryEloquent;
use Modules\Plano\Repositories\FormaPagamentoRepository;
use Modules\Plano\Repositories\FormaPagamentoRepositoryEloquent;
use Modules\Plano\Repositories\LancamentoRepository;
use Modules\Plano\Repositories\LancamentoRepositoryEloquent;
use Modules\Plano\Repositories\PlanoContratacaoRepository;
use Modules\Plano\Repositories\PlanoContratacaoRepositoryEloquent;
use Modules\Plano\Repositories\PlanoRepository;
use Modules\Plano\Repositories\PlanoRepositoryEloquent;
use Modules\Plano\Repositories\PlanoTabelaPrecoRepository;
use Modules\Plano\Repositories\PlanoTabelaPrecoRepositoryEloquent;

class PlanoServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\Plano\Http\Controllers';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        \Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('Modules/Plano/Http/api.php');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PlanoRepository::class,
            PlanoRepositoryEloquent::class
        );
        $this->app->bind(
            PlanoTabelaPrecoRepository::class,
            PlanoTabelaPrecoRepositoryEloquent::class
        );
        $this->app->bind(
            PlanoContratacaoRepository::class,
            PlanoContratacaoRepositoryEloquent::class
        );
        $this->app->bind(
            FormaPagamentoRepository::class,
            FormaPagamentoRepositoryEloquent::class
        );
        $this->app->bind(
            LancamentoRepository::class,
            LancamentoRepositoryEloquent::class
        );
        $this->app->bind(
            ContratacaoFaturaRepository::class,
            ContratacaoFaturaRepositoryEloquent::class
        );
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('plano.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'plano'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/plano');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/plano';
        }, \Config::get('view.paths')), [$sourcePath]), 'plano');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/plano');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'plano');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'plano');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
