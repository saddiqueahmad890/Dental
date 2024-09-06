<?php
namespace App\Traits;

use App\Models\UserLogs;
use App\Jobs\LogUserAction;
use Illuminate\Support\Facades\Auth;

trait Loggable
{
    public static function bootLoggable()
    {
        static::created(function ($model) {
            self::logCreate($model);
        });

        static::updated(function ($model) {
            self::logUpdate($model);
        });

        static::deleted(function ($model) {
            self::logDelete($model);
        });
    }

    protected static function logCreate($model)
    {
        $logData = [
            'user_id' => Auth::id(),
            'record_id' => $model->id,
            'action' => 'create',
            'table_name' => $model->getTable(),
            'field_name' => 'id',
            'old_value' => null,
            'new_value' => $model->id,
            'description' => 'Created record', // Example description
        ];

        LogUserAction::dispatch($logData);
    }

    protected static function logUpdate($model)
    {
        $changes = $model->getChanges();
        $original = $model->getOriginal();

        foreach ($changes as $key => $value) {
            $logData = [
                'user_id' => Auth::id(),
                'record_id' => $model->id,
                'action' => 'update',
                'table_name' => $model->getTable(),
                'field_name' => $key,
                'old_value' => $original[$key] ?? null,
                'new_value' => $value,
                'description' => "Updated {$key} from '" . ($original[$key] ?? 'N/A') . "' to '{$value}'",
            ];

            LogUserAction::dispatch($logData);
        }
    }

    protected static function logDelete($model)
    {
        $logData = [
            'user_id' => Auth::id(),
            'record_id' => $model->id,
            'action' => 'delete',
            'table_name' => $model->getTable(),
            'field_name' => 'id',
            'old_value' => $model->id,
            'new_value' => null,
            'description' => 'Deleted record', // Example description
        ];

        LogUserAction::dispatch($logData);
    }
}

