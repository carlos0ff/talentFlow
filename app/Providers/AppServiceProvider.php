<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra serviços no container.
     *
     * Ideal para bindings:
     * - Interfaces -> Implementações
     * - Singletons
     * - Serviços externos
     */
    public function register(): void
    {
        //
    }

    /**
     * Inicializa configurações globais da aplicação.
     *
     * Aqui centralizamos regras de:
     * - Segurança
     * - Proteção de banco
     * - Performance
     * - Política de senha
     * - HTTPS automático
     */
    public function boot(): void
    {
        $this->configureEloquent();
        $this->configureDatabaseProtection();
        $this->configureFrontendPerformance();
        $this->configureSecurity();
        $this->configurePasswordPolicy();
    }

    /**
     * Ativa modo estrito do Eloquent em ambiente local.
     *
     * Benefícios:
     * - Evita acessar atributos inexistentes
     * - Detecta lazy loading não intencional
     * - Evita mass assignment indevido
     *
     * Em produção é desativado para não quebrar a aplicação.
     */
    protected function configureEloquent(): void
    {
        Model::shouldBeStrict(!app()->isProduction());
    }

    /**
     * Impede execução de comandos destrutivos em produção.
     *
     * Protege contra:
     * - migrate:fresh
     * - db:wipe
     * - migrate:reset
     */
    protected function configureDatabaseProtection(): void
    {
        DB::prohibitDestructiveCommands(app()->isProduction());
    }

    /**
     * Ativa prefetch agressivo do Vite.
     *
     * Melhora performance:
     * - Pré-carregamento de JS
     * - Pré-carregamento de CSS
     * - Melhor experiência do usuário
     */
    protected function configureFrontendPerformance(): void
    {
        Vite::useAggressivePrefetching();
    }

    /**
     * Força HTTPS automaticamente em produção.
     *
     * Evita:
     * - Conteúdo misto
     * - Problemas com SSL
     * - Vulnerabilidades por HTTP
     */
    protected function configureSecurity(): void
    {
        URL::forceHttps(app()->isProduction());
    }

    /**
     * Define política global de senha.
     *
     * Produção:
     * - Mínimo 12 caracteres
     * - Letras obrigatórias
     * - Maiúsculas e minúsculas
     * - Números
     * - Símbolos
     * - Verificação contra vazamentos
     *
     * Desenvolvimento:
     * - Mínimo 6 caracteres (facilita testes)
     */
    protected function configurePasswordPolicy(): void
    {
        Password::defaults(function () {
            return app()->isProduction()
                ? Password::min(12)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
                : Password::min(6);
        });
    }
}
