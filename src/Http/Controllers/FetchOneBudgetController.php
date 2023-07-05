<?php

namespace Inisiatif\LaravelBudget\Http\Controllers;

use Inisiatif\LaravelBudget\LaravelBudget;
use Inisiatif\LaravelBudget\Contracts\FetchOneBudgetResponse;

final class FetchOneBudgetController
{
    public function show(string|int $budget): FetchOneBudgetResponse
    {
        $model = LaravelBudget::getBudgetModel()
            ->newQuery()
            ->whereCodeOrId($budget)
            ->firstOrFail();

        return app(FetchOneBudgetResponse::class, [
            'model' => $model
        ]);
    }
}
