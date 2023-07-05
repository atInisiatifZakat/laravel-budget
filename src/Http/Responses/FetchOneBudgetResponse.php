<?php

namespace Inisiatif\LaravelBudget\Http\Responses;

use Illuminate\Http\JsonResponse;
use Inisiatif\LaravelBudget\Contracts;
use Inisiatif\LaravelBudget\Models\BudgetModel;
use Inisiatif\LaravelBudget\Http\Resources\BudgetResource;

final class FetchOneBudgetResponse implements Contracts\FetchOneBudgetResponse
{
    public function __construct(
        private readonly BudgetModel $model
    )
    {
    }

    public function toResponse($request): JsonResponse
    {
        return BudgetResource::make(
            $this->model
        )->toResponse($request);
    }
}
