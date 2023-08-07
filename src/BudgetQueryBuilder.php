<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

final class BudgetQueryBuilder extends Builder
{
    /**
     * @param  string|array<array-key, string>  $attributes
     */
    public function whereLike(string|array $attributes, string $searchTerm): self
    {
        $properties = \array_map(function (string $attribute) {
            return $this->getQuery()->getGrammar()->wrap($this->qualifyColumn($attribute));
        }, Arr::wrap($attributes));

        $this->where(function (Builder $query) use ($properties, $searchTerm): void {
            $value = \mb_strtolower($searchTerm, 'UTF8');

            foreach (Arr::wrap($properties) as $property) {
                $query->orWhereRaw("LOWER({$property}) LIKE ?", "%{$value}%");
            }
        });

        return $this;
    }

    public function whereCurrentVersion(): self
    {
        return $this->where(LaravelBudget::getVersionColumnEloquentName(), now()->year);
    }

    public function whereVersion(int|string $value = null, $operator = '=', $boolean = 'and'): self
    {
        return $this->when($value, fn (BudgetQueryBuilder $builder) => $builder->where(LaravelBudget::getVersionColumnEloquentName(), $operator, $value, $boolean));
    }

    public function whereCodeOrId(int|string $value = null, $operator = '='): self
    {
        return $this->when($value !== null, function (BudgetQueryBuilder $builder) use ($value, $operator) {
            return $builder->where(function (Builder $builder) use ($value, $operator): Builder {
                return $builder->orWhere(LaravelBudget::getCodeColumnName(), $operator, $value)
                    ->orWhere(LaravelBudget::getIdColumnName(), $operator, $value);
            });
        });
    }

    public function whereCode(string $value = null, $operator = '=', $boolean = 'and'): self
    {
        return $this->when($value, fn (BudgetQueryBuilder $builder) => $builder->where(LaravelBudget::getCodeColumnName(), $operator, $value, $boolean));
    }

    public function whereDescription(string $value = null, $operator = '=', $boolean = 'and'): self
    {
        return $this->when($value, fn (BudgetQueryBuilder $builder) => $builder->where(LaravelBudget::getDescriptionColumnName(), $operator, $value, $boolean));
    }
}
