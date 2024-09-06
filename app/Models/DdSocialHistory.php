<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\services\UserLogServices;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;
use App\Traits\Loggable;

class DdSocialHistory extends Model
{
    use HasFactory,Loggable;
    protected $table="dd_social_histories";

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'created_by',
        'updated_by	',

    ];

    public function patientSocialHistory(){
        return $this->hasMany(PatientSocialHistory::class,'dd_social_history_id');
    }

    protected static function boot()
{
    parent::boot();

    $recordId = null;

    // Initialize record_id if it's null
    if ($recordId === null) {
        // Fetch the latest record_id from the user_logs table
        $latestLog = UserLogs::latest()->first();
        $recordId = $latestLog ?  (int)$latestLog->record_id + 1 : 1;
    }


    static::created(function ($model) use ($recordId) {
        // Capture the new values of the model
        // $newAttributes = $model->getAttributes();

        // // Convert the new values to a JSON string
        // $newValuesJson = json_encode($newAttributes);
        $newValue = $model->getDirty();
        $newValue = $model->getDirty();

        foreach ($newValue as $key => $value) {
           app(UserLogServices::class)->log(

               (int)$model->id ,
               $model->getTable(),
               'created',
                $key,//fieldname

               null ,//old value


               $value,//new value
            'Resource created',
           (int)$model->id
           ,

           );
       }


    });



    // Log update
     static::updating(function ($model) use ($recordId) {
        $oldValue = $model->getOriginal();
     $newValue = $model->getDirty();

         foreach ($newValue as $key => $value) {
            app(UserLogServices::class)->log(

                (int)$model->id ,
                $model->getTable(),
                'updated',
                 $key,//fieldname
                // json_encode($oldValue[$key] ?? null),//old value
                $oldValue[$key] ,//old value

                // json_encode($value),//new value
            $value,//new value
             'Resource updated',
            (int)$model->id
            ,

            );
        }
    });

    // Log deletion
  static::deleted(function ($model) use ($recordId) {
    app(UserLogServices::class)->log(

        (int)$model->id , //going from system formula
        $model->getTable(),
        'delete',
        null,//fieldname
        json_encode($model->getAttributes()),
        null,//old value
        // json_encode($model->getAttributes()),
        'Resource deleted',
        (int)$model->id
    );


    });

}

}
