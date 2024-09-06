<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student2 extends Model
{
    use HasFactory;
    public $timestamps=false;
     //  for log
     protected static function boot(){
        parent::boot();

        $recordId = null;

        // Initialize record_id if it's null
        if ($recordId === null) {
            // Fetch the latest record_id from the user_logs table
            $latestLog = UserLogs::latest()->first();
            $recordId = $latestLog ?  (int)$latestLog->record_id + 1 : 1;
        }


        static::created(function ($model) use ($recordId) {

            $newValue = $model->getDirty();
            $newValue = $model->getDirty();

            foreach ($newValue as $key => $value) {
                app(UserLogServices::class)->log(

                    (int)$model->id,
                    $model->getTable(),
                    'created',
                    $key, //fieldname
                    // json_encode($oldValue[$key] ?? null),//old value
                    null, //old value

                    // json_encode($value),//new value
                    $value, //new value
                    'Resource created',
                    (int)$model->id,

                );
            }
        });




        static::updating(function ($model) {
            $oldValue = $model->getOriginal();
            $newValue = $model->getDirty();

            foreach ($newValue as $key => $value) {
                // Check if the old value exists before logging
                $oldValueExists = array_key_exists($key, $oldValue);

                app(UserLogServices::class)->log(
                    (int)$model->id,
                    $model->getTable(),
                    'updated',
                    $key, // field name
                    $oldValueExists ? $oldValue[$key] : null, // old value
                    $value, // new value
                    'Resource updated',
                    (int)$model->id
                );
            }
        });


        // Log deletion
        static::deleted(function ($model) use ($recordId) {
            app(UserLogServices::class)->log(

                (int)$model->id, //going from system formula
                $model->getTable(),
                'delete',
                null, //fieldname
                json_encode($model->getAttributes()),
                null, //old value
                // json_encode($model->getAttributes()),
                'Resource deleted',
                (int)$model->id
            );
        });
    }
}
