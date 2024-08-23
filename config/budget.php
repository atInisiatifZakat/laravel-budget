<?php

declare(strict_types=1);

return [
    /**
     * This is connection database must be available in database config
     */
    'connection' => env('LARAVEL_BUDGET_ELOQUENT_CONNECTION', env('DB_CONNECTION', 'sqlite')),

    /**
     * This is table name for budget
     */
    'table' => env('LARAVEL_BUDGET_ELOQUENT_TABLE', 'budgets'),

    /**
     * Indicated must be running migration, internally used in testing
     */
    'migration' => env('LARAVEL_BUDGET_ELOQUENT_MIGRATION', false),

    /**
     * Column name mapping, you can change this value is column name is different
     */
    'columns' => [
        'id' => 'id',
        'code' => 'code',
        'description' => 'description',
        'total_amount' => 'total_amount',
        'usage_amount' => 'usage_amount',
        'legacy_usage_amount' => 'legacy_usage_amount',
        'is_over' => 'is_over',
    ],

    'include_legacy_usage_amount'  => env('INCLUDE_LEGACY_USAGE_AMOUNT', true),

    /**
     * Column type for version column
     *
     * Support: int, string, json
     */
    'version_column_type' => 'int',

    /**
     * Column version name
     */
    'version_column_name' => 'year',

    /**
     * For json type fill using json path, ex : `version->year`
     */
    'version_json_column_path' => null,

    /**
     * Disable or enable timestamps in model
     */
    'model_uses_timestamps' => true,
];
