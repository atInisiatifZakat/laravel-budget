<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Tests\Http\Controllers;

use Illuminate\Support\Str;
use Inisiatif\LaravelBudget\LaravelBudget;
use Inisiatif\LaravelBudget\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inisiatif\LaravelBudget\Database\Factories\BudgetFactory;

final class FilterCurrentBudgetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_filter_current_budget(): void
    {
        BudgetFactory::new([
            LaravelBudget::getVersionColumnName() => now()->year,
        ])->count(2)->create();
        BudgetFactory::new()->count(2)->create();

        $response = $this->getJson('/budget/current')->assertSuccessful();

        $this->assertCount(2, $response->json('data'));
    }

    public function test_can_filter_current_budget_using_code(): void
    {
        BudgetFactory::new([
            LaravelBudget::getVersionColumnName() => now()->year,
            LaravelBudget::getCodeColumnName() => 'CODE'.Str::random(),
        ])->count(2)->create();
        BudgetFactory::new([
            LaravelBudget::getCodeColumnName() => 'CODE'.Str::random(),
        ])->count(2)->create();

        $response = $this->getJson('/budget/current?code=CODE')->assertSuccessful();

        $this->assertCount(2, $response->json('data'));
    }

    public function can_filter_budget_using_description(): void
    {
        BudgetFactory::new([
            LaravelBudget::getVersionColumnName() => now()->year,
            LaravelBudget::getDescriptionColumnName() => 'Foo Bar',
        ])->count(2)->create();
        BudgetFactory::new([
            LaravelBudget::getDescriptionColumnName() => 'Foo Bar',
        ])->count(2)->create();

        $response = $this->getJson('/budget/current?description=Foo')->assertSuccessful();

        $this->assertCount(2, $response->json('data'));
    }
}
