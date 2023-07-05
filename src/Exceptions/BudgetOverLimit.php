<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Exceptions;

use Exception;

final class BudgetOverLimit extends Exception
{
    public static function make(float|int $totalAmount, float|int $newAmount): self
    {
        return new self(
            \sprintf('Budget cannot over usage, current usage is %s from %s', $newAmount, $totalAmount)
        );
    }
}
