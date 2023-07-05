<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget;

use Illuminate\Database\Eloquent\Builder;

final class BudgetQueryBuilder extends Builder
{
    public function whereCurrentVersion(): self
    {
        return $this->where(LaravelBudget::getVersionColumnName(), now()->year);
    }

    public function whereVersion(int|string|null $value = null, $operator = null, $boolean = 'and'): self
    {
        return $this->when($value, fn (BudgetQueryBuilder $builder) => $builder->where(LaravelBudget::getVersionColumnName(), $operator, $value, $boolean));
    }

    public function whereCodeOrId(?string $value = null, $operator = null): self
    {
        return $this->when($value, function (BudgetQueryBuilder $builder) use ($value, $operator) {
            return $builder->where(function (Builder $builder)  use ($value, $operator) : Builder {
                return $builder->orWhere(LaravelBudget::getCodeColumnName(), $operator, $value)
                    ->orWhere(LaravelBudget::getCodeColumnName(), $operator, $value);
            });
        });
    }

    public function whereCode(?string $value = null, $operator = null, $boolean = 'and'): self
    {
        return $this->when($value, fn (BudgetQueryBuilder $builder) => $builder->where(LaravelBudget::getCodeColumnName(), $operator, $value, $boolean));
    }

    public function whereDescription(?string $value = null, $operator = null, $boolean = 'and'): self
    {
        return $this->when($value, fn (BudgetQueryBuilder $builder) => $builder->where(LaravelBudget::getDescriptionColumnName(), $operator, $value, $boolean));
    }
}
