<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Tests\Http\Controllers;

use Inisiatif\LaravelBudget\LaravelBudget;
use Inisiatif\LaravelBudget\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inisiatif\LaravelBudget\Database\Factories\BudgetFactory;

final class FilterBudgetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_filter_budget(): void
    {
        BudgetFactory::new()->count(2)->create();

        $response = $this->getJson('/budget')->assertSuccessful();

        $this->assertCount(2, $response->json('data'));
    }

    public function test_can_filter_budget_using_version(): void
    {
        BudgetFactory::new([
            LaravelBudget::getVersionColumnName() => now()->year,
        ])->count(2)->create();
        BudgetFactory::new()->count(2)->create();

        $response = $this->getJson('/budget?version='.now()->year)->assertSuccessful();

        $this->assertCount(2, $response->json('data'));
    }

    public function test_can_filter_budget_using_code(): void
    {
        BudgetFactory::new([
            LaravelBudget::getCodeColumnName() => 'CODE'.now()->year,
        ])->count(2)->create();
        BudgetFactory::new()->count(2)->create();

        $response = $this->getJson('/budget?code='.now()->year)->assertSuccessful();

        $this->assertCount(2, $response->json('data'));
    }

    public function test_can_filter_budget_using_description(): void
    {
        BudgetFactory::new([
            LaravelBudget::getDescriptionColumnName() => 'Foo Bar',
        ])->count(2)->create();
        BudgetFactory::new()->count(2)->create();

        $response = $this->getJson('/budget?description=Foo')->assertSuccessful();

        $this->assertCount(2, $response->json('data'));
    }
}
