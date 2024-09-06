<?php

namespace App\Services;

use App\Models\UserLogs;
use Illuminate\Support\Facades\Auth;

class UserLogServices
{
    public function log($record_id,$table_name,  $action, $field_name = null, $old_value = null, $new_value = null, $description = null,$student_id)
    {
        UserLogs::create([
            'user_id' => Auth::id(),
            'record_id' => $record_id,
            'table_name' => $table_name,
            'action' => $action,
            'field_name' => $field_name,
            'old_value' => $old_value,
            'new_value' => $new_value,
            'description' => $description,




        ]);
    }
}

