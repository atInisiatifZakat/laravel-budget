<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Contracts;

interface HasUsageOperation
{
    public function increaseUsage(float|int $amount): void;

    public function decreaseUsage(float|int $amount): void;
}
