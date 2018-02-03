<?php

namespace Modules\Transporte\Providers;

use Illuminate\Support\ServiceProvider;

class TransporteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\Transporte\Http\Controllers';
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

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

    public function bootValidators(){
        \Validator::extend('cpf_validator', function ($attribute, $value, $parameters, $validator) {
            $valid = false;
            if(validar_cnpj($value)){
                $valid = true;
            }
            if(validar_cpf($value)){
                $valid = true;
            }
            return $valid;
        },'CPF/CNPJ Inválido!');
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
            require base_path('Modules/Transporte/Http/api.php');
        });
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->bootValidators();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('transporte.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'transporte'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/transporte');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/transporte';
        }, \Config::get('view.paths')), [$sourcePath]), 'transporte');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/transporte');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'transporte');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'transporte');
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
