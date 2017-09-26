<?php

namespace Portal\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Portal\Model' => 'Portal\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes(null, [
            'prefix' => 'api/v1','middleware' => ['cors']
        ]);
        Passport::tokensExpireIn(Carbon::now()->addDay(1));
        Passport::refreshTokensExpireIn(Carbon::now()->addDay(2));
    }
}
