<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Inisiatif\LaravelBudget\Contracts\HasBudget;
use Inisiatif\LaravelBudget\LaravelBudget;

final class BudgetResource extends JsonResource
{
    public function toArray($request): array
    {
        if (! $this->resource instanceof HasBudget) {
            throw new \RuntimeException('$resource must be instanceof ' . HasBudget::class);
        }

        return [
            'id' => $this->resource->getId(),
            'code' => $this->resource->getCode(),
            'description' => $this->resource->getDescription(),
            'total_amount' => $this->resource->getTotalAmount(),
            'usage_amount' => $this->resource->getUsageAmount(),
            'legacy_usage_amount' => $this->resource->getLegacyUsageAmount(),
            'balance_amount' => $this->resource->getBalance(),
            'is_over' => $this->resource->isOver(),
            'is_limit_reached' => $this->resource->isLimitReached(),
            'version' => $this->resource->getVersion()
        ];
    }
}
