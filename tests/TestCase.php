<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Database\Eloquent\Factories\Factory;
use Inisiatif\LaravelBudget\LaravelBudgetServiceProvider;

final class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            static fn (string $modelName) => 'Inisiatif\\LaravelBudget\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelBudgetServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        \config()->set('database.default', 'testing');
    }
}
