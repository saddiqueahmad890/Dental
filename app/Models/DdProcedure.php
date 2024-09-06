<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserLogs;
use App\services\UserLogServices;
use App\Traits\Loggable;
use Illuminate\Support\Facades\Auth;

class DdProcedure extends Model
{
    use HasFactory,Loggable;
    protected $table = "dd_procedures";

    protected $fillable = [
        'id',
        'title',
        'description',
        'created_by',
        'sr_no',
        'price',
        'dd_procedure_id',
        'procedure_code',
        'updated_by'

    ];
    public function ddprocedurecategory()
    {
        return $this->belongsto(DdProcedureCategory::class, 'dd_procedure_id');
    }
    public function newreport()
    {
        return $this->hasMany(NewReport::class);
    }
}
