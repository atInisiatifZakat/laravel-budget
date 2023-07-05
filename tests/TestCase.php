<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Tests;

use Orchestra\Testbench;
use Inisiatif\LaravelBudget\LaravelBudget;
use Illuminate\Contracts\Config\Repository;
use Inisiatif\LaravelBudget\LaravelBudgetServiceProvider;

abstract class TestCase extends Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelBudgetServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        \tap($app->make('config'), static function (Repository $config): void {
            $config->set('database.default', 'testing');

            $config->set('database.connections.testing', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);

            $config->set('budget.connection', 'testing');
            $config->set('budget.migration', true);
        });
    }

    protected function defineRoutes($router): void
    {
        $router->group([], static function (): void {
            LaravelBudget::routes();
        });
    }

    protected function defineDatabaseMigrations(): void
    {
        Testbench\artisan($this, 'migrate', ['--database' => 'testing']);

        $this->beforeApplicationDestroyed(
            fn () => Testbench\artisan($this, 'migrate:rollback', ['--database' => 'testing'])
        );
    }
}
