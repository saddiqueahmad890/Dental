<?php

namespace App\Models;
use App\services\UserLogServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabReportTemplate extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'template',
        'created_by',
        'updated_by'
    ];

    public function labReports()
    {
        return $this->hasMany(LabReport::class);
    }

}
