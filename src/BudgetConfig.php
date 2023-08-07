<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget;

use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;

final class BudgetConfig
{
    private readonly array $config;

    public function __construct(array $config)
    {
        Assert::keyExists($config, 'connection');
        Assert::keyExists($config, 'table');
        Assert::keyExists($config, 'columns');

        $this->config = $config;
    }

    public function getConnectionName(): string
    {
        return Arr::get($this->config, 'connection');
    }

    public function getTableName(): string
    {
        return Arr::get($this->config, 'table');
    }

    public function getIdColumnName(): string
    {
        return Arr::get($this->config, 'columns.id', 'id');
    }

    public function getCodeColumnName(): string
    {
        return Arr::get($this->config, 'columns.code', 'code');
    }

    public function getDescriptionColumnName(): string
    {
        return Arr::get($this->config, 'columns.description', 'description');
    }

    public function getTotalAmountColumnName(): string
    {
        return Arr::get($this->config, 'columns.total_amount', 'total_amount');
    }

    public function getUsageAmountColumnName(): string
    {
        return Arr::get($this->config, 'columns.usage_amount', 'usage_amount');
    }

    public function isModelUsesTimestamps(): bool
    {
        return Arr::get($this->config, 'model_uses_timestamps', true);
    }

    public function getIsOverAmountColumnName(): string
    {
        return Arr::get($this->config, 'columns.is_over', 'is_over');
    }

    public function getVersionColumnName(): string
    {
        return Arr::get($this->config, 'version_column_name', 'year');
    }

    public function getVersionColumnEloquentName(): string
    {
        if ($this->getVersionColumnType() === 'json') {
            $path = Arr::get($this->config, 'version_json_column_path');

            Assert::notNull($path);

            return $path;
        }

        return $this->getVersionColumnName();
    }

    public function getVersionColumnType(): string
    {
        return Arr::get($this->config, 'version_column_type', 'int');
    }
}
