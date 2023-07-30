<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Inisiatif\LaravelBudget\LaravelBudget;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection(LaravelBudget::getConnectionName())->create(LaravelBudget::getTableName(), static function (Blueprint $table): void {
            $table->unsignedBigInteger(LaravelBudget::getIdColumnName())->autoIncrement();
            $table->string(LaravelBudget::getCodeColumnName())->nullable();
            $table->string(LaravelBudget::getDescriptionColumnName())->nullable();
            $table->unsignedBigInteger(LaravelBudget::getTotalAmountColumnName())->nullable();
            $table->unsignedBigInteger(LaravelBudget::getUsageAmountColumnName())->nullable();
            $table->boolean(LaravelBudget::getIsOverAmountColumnName())->nullable();

            if (LaravelBudget::getVersionColumnType() === 'json') {
                $table->json(LaravelBudget::getVersionColumnName())->nullable();
            } else {
                $table->string(LaravelBudget::getVersionColumnName())->nullable();
            }

            if (LaravelBudget::isModelUsesTimestamps()) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::connection(LaravelBudget::getConnectionName())->dropIfExists(LaravelBudget::getTableName());
    }
};
