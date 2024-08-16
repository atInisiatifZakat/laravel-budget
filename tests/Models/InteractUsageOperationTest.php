<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Tests\Models;

use Inisiatif\LaravelBudget\LaravelBudget;
use Inisiatif\LaravelBudget\Tests\TestCase;
use Inisiatif\LaravelBudget\Models\BudgetModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inisiatif\LaravelBudget\Exceptions\BudgetOverLimit;
use Inisiatif\LaravelBudget\Database\Factories\BudgetFactory;

final class InteractUsageOperationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_increase_usage(): void
    {
        BudgetFactory::new()->createOne([
            LaravelBudget::getUsageAmountColumnName() => 1000,
            LaravelBudget::getOldUsageAmountColumnName() => 500,
            LaravelBudget::getTotalAmountColumnName() => 3000,
        ]);

        /** @var BudgetModel $budget */
        $budget = LaravelBudget::getBudgetModel()->newQuery()->first();

        $budget->increaseUsage(1000);

        $budget->refresh();

        $this->assertSame($budget->getUsageAmount(), 2000.0);
    }

    public function test_can_increase_over_usage_when_is_over_true(): void
    {
        BudgetFactory::new()->createOne([
            LaravelBudget::getTotalAmountColumnName() => 2000,
            LaravelBudget::getUsageAmountColumnName() => 1000,
            LaravelBudget::getOldUsageAmountColumnName() => 1000,
            LaravelBudget::getIsOverAmountColumnName() => true,
        ]);

        /** @var BudgetModel $budget */
        $budget = LaravelBudget::getBudgetModel()->newQuery()->first();

        $budget->increaseUsage(1000);

        $budget->refresh();

        $this->assertSame($budget->getUsageAmount(), 2000.0);
    }

    public function test_can_decrease_usage(): void
    {
        BudgetFactory::new([
            LaravelBudget::getUsageAmountColumnName() => 1000,
        ])->createOne();

        /** @var BudgetModel $budget */
        $budget = LaravelBudget::getBudgetModel()->newQuery()->first();

        $budget->decreaseUsage(500);

        $budget->refresh();

        $this->assertSame($budget->getUsageAmount(), 500.0);
    }

    public function test_cannot_increase_usage_over_limit(): void
    {
        $this->expectException(BudgetOverLimit::class);

        BudgetFactory::new()->createOne([
            LaravelBudget::getTotalAmountColumnName() => 2000,
            LaravelBudget::getOldUsageAmountColumnName() => 1000,
            LaravelBudget::getUsageAmountColumnName() => 1000,
            LaravelBudget::getIsOverAmountColumnName() => false,
        ]);

        /** @var BudgetModel $budget */
        $budget = LaravelBudget::getBudgetModel()->newQuery()->first();

        $budget->increaseUsage(500);

        $budget->refresh();

        $this->assertSame($budget->getUsageAmount(), 1000.0);
    }

    public function test_cannot_decrease_usage_when_zero(): void
    {
        BudgetFactory::new()->createOne([
            LaravelBudget::getUsageAmountColumnName() => 0,
        ]);

        /** @var BudgetModel $budget */
        $budget = LaravelBudget::getBudgetModel()->newQuery()->first();

        $budget->decreaseUsage(500);

        $budget->refresh();

        $this->assertSame($budget->getUsageAmount(), 0.0);
    }
}
