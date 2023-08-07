<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget;

use Webmozart\Assert\Assert;
use Inisiatif\LaravelBudget\Models\Budget;
use Inisiatif\LaravelBudget\Models\BudgetModel;

final class LaravelBudget
{
    /** @var class-string<BudgetModel> */
    private static string $modelClass = Budget::class;

    public static function getBudgetModel(): BudgetModel
    {
        return app(
            self::getBudgetModelClass()
        );
    }

    /**
     * @return class-string<BudgetModel>
     */
    public static function getBudgetModelClass(): string
    {
        return self::$modelClass;
    }

    /**
     * @param class-string<BudgetModel> $model
     */
    public static function useBudgetModelClass(string $model): void
    {
        Assert::classExists($model);

        self::$modelClass = $model;
    }

    public static function getConnectionName(): string
    {
        return self::getBudgetConfig()->getConnectionName();
    }

    public static function getTableName(): string
    {
        return self::getBudgetConfig()->getTableName();
    }

    public static function getIdColumnName(): string
    {
        return self::getBudgetConfig()->getIdColumnName();
    }

    public static function getCodeColumnName(): string
    {
        return self::getBudgetConfig()->getCodeColumnName();
    }

    public static function getDescriptionColumnName(): string
    {
        return self::getBudgetConfig()->getDescriptionColumnName();
    }

    public static function getTotalAmountColumnName(): string
    {
        return self::getBudgetConfig()->getTotalAmountColumnName();
    }

    public static function getUsageAmountColumnName(): string
    {
        return self::getBudgetConfig()->getUsageAmountColumnName();
    }

    public static function getIsOverAmountColumnName(): string
    {
        return self::getBudgetConfig()->getIsOverAmountColumnName();
    }

    public static function isModelUsesTimestamps(): bool
    {
        return self::getBudgetConfig()->isModelUsesTimestamps();
    }

    public static function getVersionColumnName(): string
    {
        return self::getBudgetConfig()->getVersionColumnName();
    }

    public static function getVersionColumnEloquentName(): string
    {
        return self::getBudgetConfig()->getVersionColumnEloquentName();
    }

    public static function getVersionColumnType(): string
    {
        return self::getBudgetConfig()->getVersionColumnType();
    }

    public static function routes(): void
    {
        BudgetRoutes::routes();
    }

    private static function getBudgetConfig(): BudgetConfig
    {
        return app(BudgetConfig::class);
    }
}
