<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Models\Traits;

use Inisiatif\LaravelBudget\LaravelBudget;

trait InteractWithBudget
{
    public function getConnectionName(): string
    {
        return LaravelBudget::getConnectionName();
    }

    public function getTable(): string
    {
        return LaravelBudget::getTableName();
    }

    public function getId(): string|int
    {
        return $this->getAttribute(
            LaravelBudget::getIdColumnName()
        );
    }

    public function getCode(): string
    {
        return $this->getAttribute(
            LaravelBudget::getCodeColumnName()
        );
    }

    public function getDescription(): string
    {
        return $this->getAttribute(
            LaravelBudget::getDescriptionColumnName()
        );
    }

    public function getTotalAmount(): int|float
    {
        return (float) $this->getAttribute(
            LaravelBudget::getTotalAmountColumnName()
        );
    }

    public function getUsageAmount(): int|float
    {
        return (float) $this->getAttribute(
            LaravelBudget::getUsageAmountColumnName()
        );
    }

    public function getLegacyUsageAmount(): int|float
    {
        return (float) $this->getAttribute(
            LaravelBudget::getLegacyUsageAmountColumnName()
        );
    }

    public function getBalance(): int|float
    {
        return $this->getTotalAmount() - $this->getUsageAmount();
    }

    public function isOver(): bool
    {
        return (bool) $this->getAttribute(
            LaravelBudget::getIsOverAmountColumnName()
        );
    }

    public function isLimitReached(): bool
    {
        return $this->getUsageAmount() >= $this->getTotalAmount();
    }
}
