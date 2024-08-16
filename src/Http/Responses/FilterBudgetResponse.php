<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Http\Responses;

use Illuminate\Http\JsonResponse;
use Inisiatif\LaravelBudget\Contracts;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Inisiatif\LaravelBudget\Http\Resources\BudgetResource;

final class FilterBudgetResponse implements Contracts\FilterBudgetResponse
{
    public function __construct(
        private readonly CursorPaginator $paginator
    ) {}

    public function toResponse($request): JsonResponse
    {
        return BudgetResource::collection(
            $this->paginator
        )->toResponse($request);
    }
}
