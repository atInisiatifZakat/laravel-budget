<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Models\Traits;

use Inisiatif\LaravelBudget\LaravelBudget;
use Inisiatif\LaravelBudget\Exceptions\BudgetOverLimit;

trait InteractUsageOperation
{
    /**
     * @throws BudgetOverLimit
     */
    public function increaseUsage(float|int $amount): void
    {
        if ($this->exists === false) {
            throw new \RuntimeException('Model not exists');
        }

        $newAmount = $this->getUsageAmount() + $this->getOldUsageAmount() + $amount;

        if ((int) $newAmount >= (int) $this->getTotalAmount() && $this->isOver() === false) {
            throw BudgetOverLimit::make($this->getTotalAmount(), $newAmount);
        }

        $this->increment(
            LaravelBudget::getUsageAmountColumnName(),
            $amount
        );
    }

    public function decreaseUsage(float|int $amount): void
    {
        if ($this->exists === false) {
            throw new \RuntimeException('Model not exists');
        }

        if ((int) $this->getUsageAmount() > 0) {
            $this->decrement(
                LaravelBudget::getUsageAmountColumnName(),
                $amount
            );
        }
    }
}
