<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Models;

use Illuminate\Database\Eloquent\Model;
use Inisiatif\LaravelBudget\LaravelBudget;
use Inisiatif\LaravelBudget\BudgetQueryBuilder;
use Inisiatif\LaravelBudget\Contracts\HasBudget;
use Inisiatif\LaravelBudget\Contracts\HasUsageOperation;
use Inisiatif\LaravelBudget\Models\Traits\InteractWithBudget;
use Inisiatif\LaravelBudget\Models\Traits\InteractUsageOperation;

abstract class BudgetModel extends Model implements HasBudget, HasUsageOperation
{
    use InteractUsageOperation;
    use InteractWithBudget;

    public static function query(): BudgetQueryBuilder
    {
        /** @var BudgetQueryBuilder */
        return parent::query();
    }

    public function newQuery(): BudgetQueryBuilder
    {
        /** @var BudgetQueryBuilder */
        return parent::newQuery();
    }

    public function newEloquentBuilder($query): BudgetQueryBuilder
    {
        return new BudgetQueryBuilder($query);
    }

    public function usesTimestamps(): bool
    {
        if (LaravelBudget::isModelUsesTimestamps()) {
            return parent::usesTimestamps();
        }

        return LaravelBudget::isModelUsesTimestamps();
    }
}
