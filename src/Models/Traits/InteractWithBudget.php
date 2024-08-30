<?php

declare(strict_types=1);

namespace Inisiatif\LaravelBudget\Models\Traits;

use Inisiatif\LaravelBudget\LaravelBudget;
use Inisiatif\LaravelBudget\Exceptions\BudgetOverLimit;

trait InteractWithBudget
{
    public function getConnectionName(): string
    {
        return LaravelBudget::getConnectionName();
    }

    public function getTable(): string
    {
        return LaravelBudget::getTableName();
    }

    public function getId(): string|int
    {
        return $this->getAttribute(
            LaravelBudget::getIdColumnName()
        );
    }

    public function getCode(): string
    {
        return $this->getAttribute(
            LaravelBudget::getCodeColumnName()
        );
    }

    public function getDescription(): string
    {
        return $this->getAttribute(
            LaravelBudget::getDescriptionColumnName()
        );
    }

    public function getTotalAmount(): int|float
    {
        return (float) $this->getAttribute(
            LaravelBudget::getTotalAmountColumnName()
        );
    }

    public function getUsageAmount(): int|float
    {
        return (float) $this->getAttribute(
            LaravelBudget::getUsageAmountColumnName()
        );
    }

    public function getLegacyUsageAmount(): int|float
    {
        return (float) $this->getAttribute(
            LaravelBudget::getLegacyUsageAmountColumnName()
        );
    }

    public function getBalance(): int|float
    {
        return $this->getTotalAmount() - $this->getUsageAmount();
    }

    public function isOver(): bool
    {
        return (bool) $this->getAttribute(
            LaravelBudget::getIsOverAmountColumnName()
        );
    }

    public function isLimitReached(): bool
    {
        return $this->getUsageAmount() >= $this->getTotalAmount();
    }

    public function getTotalUsageAmount(): float
    {
        $totalUsageAmount = $this->getUsageAmount();

        if (LaravelBudget::includeLegacyUsageAmountName()) {
            $totalUsageAmount = $this->getUsageAmount() + $this->getLegacyUsageAmount();
        }

        return $totalUsageAmount;
    }

    public function isOverUsage(float $newAmount, bool $exception = true): bool
    {
        // Hitung jumlah baru setelah penambahan
        $newTotalUsage = $this->getTotalUsageAmount() + $newAmount;

        // Cek apakah jumlah baru melebihi total anggaran
        if ((int) $newTotalUsage >= (int) $this->getTotalAmount() && $this->isOver() === false) {
            // Jika opsi exception aktif, lempar exception
            if ($exception) {
                throw BudgetOverLimit::make($this->getTotalAmount(), $newTotalUsage);
            }

            // Kembalikan nilai true jika over budget
            return true;
        }

        // Kembalikan nilai false jika tidak over budget
        return false;
    }

    public function getVersion()
    {
        $version = LaravelBudget::getVersionColumnEloquentName();

        // Jika 'metadata->implementation->year', ambil nilai dari JSON
        if ($version === LaravelBudget::getVersionJsonColumnPath()) {
            $metadata = $this->getAttribute(LaravelBudget::getVersionColumnName());

            return json_decode($metadata, true);
        }

        return $this->getAttribute($version);
    }
}
