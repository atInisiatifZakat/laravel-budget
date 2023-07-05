<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Models\Traits;

use Inisiatif\LaravelBudget\LaravelBudget;

trait InteractUsageOperation
{
    public function increaseUsage(float|int $amount): void
    {
        $this->increment(
            LaravelBudget::getUsageAmountColumnName(), $amount
        );
    }

    public function decreaseUsage(float|int $amount): void
    {
        $this->decrement(
            LaravelBudget::getUsageAmountColumnName(), $amount
        );
    }
}
