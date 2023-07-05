<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Inisiatif\LaravelBudget\Http\Responses\FilterBudgetResponse;
use Inisiatif\LaravelBudget\Http\Responses\FetchOneBudgetResponse;

final class LaravelBudgetServiceProvider extends PackageServiceProvider
{
    public function registeringPackage(): void
    {
        $this->app->bind(Contracts\FilterBudgetResponse::class, FilterBudgetResponse::class);
        $this->app->bind(Contracts\FetchOneBudgetResponse::class, FetchOneBudgetResponse::class);
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-budget')
            ->hasConfigFile()
            ->hasMigration('create_budget_table');
    }

    public function bootingPackage(): void
    {
        $this->app->singleton(BudgetConfig::class, fn () => new BudgetConfig(
            (array) \config('budget', [])
        ));

        $this->package->runsMigrations(
            (bool) \config('budget.migration')
        );
    }
}
