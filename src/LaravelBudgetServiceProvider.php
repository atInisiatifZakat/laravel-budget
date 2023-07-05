<?php

namespace Inisiatif\LaravelBudget;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelBudgetServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-budget')
            ->hasConfigFile()
            ->hasMigration('create_budget_table');
    }
}
