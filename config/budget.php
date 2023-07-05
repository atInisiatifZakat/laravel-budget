<?php

declare(strict_types=1);

return [
    'connection' => env('LARAVEL_BUDGET_ELOQUENT_CONNECTION', env('DB_CONNECTION', 'sqlite')),

    'table' => env('LARAVEL_BUDGET_ELOQUENT_TABLE', 'budgets'),

    'migration' => env('LARAVEL_BUDGET_ELOQUENT_MIGRATION', false),

    'columns' => [
        'id' => 'id',
        'code' => 'code',
        'description' => 'description',
        'total_amount' => 'total_amount',
        'usage_amount' => 'usage_amount',
        'is_over' => 'is_over',
    ],

    /**
     * Column version name, for json type fill using json path, ex : `version->year`
     */
    'version_column_name' => 'year',

    /**
     * Column type for version column
     *
     * Support: int, string, json
     */
    'version_column_type' => 'int',

    /**
     * Disable or enable timestamps in model
     */
    'model_uses_timestamps' => true,
];
