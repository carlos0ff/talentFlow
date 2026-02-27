<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Vite;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;

use Faker\Factory;
use Faker\Generator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /** Configura modo estrito do Eloquent **/
       Model::shouldBeStrict(!$this->app->isProduction());

       /** Protege banco contra comandos destrutivos em produção **/
       DB::prohibitDestructiveCommands($this->app->isProduction());

        /** Melhora performance do frontend **/
        app(Vite::class)->useAggressivePrefetching();

        /** Configura segurança de URL **/
        if ($this->app->isProduction()) {
            URL::forceHttps();
        }

        /** Define política global de senha **/
        Password::defaults(function () {
            return $this->app->isProduction()
                ? Password::min(12)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
                : Password::max(255);
        });

        /** Registra o Faker com localidade brasileira  **/
        $this->app->singleton(Generator::class, function () {
            return Factory::create('pt_BR');
        });
    }
}
