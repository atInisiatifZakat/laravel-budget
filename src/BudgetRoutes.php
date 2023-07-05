<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget;

use Illuminate\Support\Facades\Route;
use Inisiatif\LaravelBudget\Http\Controllers\FilterBudgetController;
use Inisiatif\LaravelBudget\Http\Controllers\FilterCurrentBudgetController;

final class BudgetRoutes
{
    public static function routes(): void
    {
        Route::get('/budget', [FilterBudgetController::class, 'index']);
        Route::get('/budget/current', [FilterCurrentBudgetController::class, 'index']);
    }
}
