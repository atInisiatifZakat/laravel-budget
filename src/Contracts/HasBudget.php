<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Contracts;

interface HasBudget
{
    public function getId(): string|int;

    public function getCode(): string;

    public function getDescription(): string;

    public function getTotalAmount(): int|float;

    public function getUsageAmount(): int|float;

    public function getOldUsageAmount(): int|float;

    public function getBalance(): int|float;

    public function isOver(): bool;

    public function isLimitReached(): bool;
}
