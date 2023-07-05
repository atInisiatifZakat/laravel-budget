<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Http\Controllers;

use Illuminate\Http\Request;
use Inisiatif\LaravelBudget\LaravelBudget;
use Inisiatif\LaravelBudget\Http\Responses\FilterBudgetResponse;

final class FilterCurrentBudgetController
{
    public function index(Request $request): FilterBudgetResponse
    {
        $paginator = LaravelBudget::getBudgetModel()
            ->newQuery()
            ->whereCurrentVersion()
            ->whereLike(LaravelBudget::getCodeColumnName(), (string) $request->string('code'))
            ->whereLike(LaravelBudget::getDescriptionColumnName(), (string) $request->string('description'))
            ->cursorPaginate($request->integer('limit'))
            ->appends((array) $request->query());

        return app(FilterBudgetResponse::class, [
            'paginator' => $paginator,
        ]);
    }
}
