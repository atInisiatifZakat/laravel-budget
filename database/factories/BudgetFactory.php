<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Database\Factories;

use Inisiatif\LaravelBudget\LaravelBudget;
use Inisiatif\LaravelBudget\Models\Budget;
use Illuminate\Database\Eloquent\Factories\Factory;

final class BudgetFactory extends Factory
{
    protected $model = Budget::class;

    public function definition(): array
    {
        return [
            LaravelBudget::getCodeColumnName() => $this->faker->randomNumber(),
            LaravelBudget::getDescriptionColumnName() => $this->faker->sentence(),
            LaravelBudget::getTotalAmountColumnName() => $this->faker->randomNumber(),
            LaravelBudget::getUsageAmountColumnName() => $this->faker->randomNumber(),
            LaravelBudget::getOldUsageAmountColumnName() => $this->faker->randomNumber(),
            LaravelBudget::getIsOverAmountColumnName() => $this->faker->boolean(),
            LaravelBudget::getVersionColumnName() => now()->year,
        ];
    }
}
