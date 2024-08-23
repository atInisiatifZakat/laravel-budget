<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Tests\Models;

use Inisiatif\LaravelBudget\LaravelBudget;
use Inisiatif\LaravelBudget\Tests\TestCase;
use Inisiatif\LaravelBudget\Contracts\HasBudget;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inisiatif\LaravelBudget\Database\Factories\BudgetFactory;

final class InteractWithBudgetTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_return_valid_value(): void
    {
        BudgetFactory::new()->createOne([
            LaravelBudget::getTotalAmountColumnName() => 2000,
            LaravelBudget::getUsageAmountColumnName() => 1000,
            LaravelBudget::getLegacyUsageAmountColumnName() => 1000,
            LaravelBudget::getIsOverAmountColumnName() => false,
        ]);

        /** @var HasBudget $budget */
        $budget = LaravelBudget::getBudgetModel()->newQuery()->first();

        $this->assertSame(1000.0, $budget->getBalance());
        $this->assertSame(1000.0, $budget->getUsageAmount());
        $this->assertSame(1000.0, $budget->getLegacyUsageAmount());
        $this->assertSame(2000.0, $budget->getTotalAmount());
        $this->assertFalse($budget->isLimitReached());
        $this->assertFalse($budget->isOver());
    }
}
