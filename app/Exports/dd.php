<?php

namespace App\Exports;

use App\Models\DdBloodGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class DdBloodGroupExport implements FromView
{
    protected $bloodGroups;

    public function __construct(Request $request)
    {
        $this->bloodGroups = DdBloodGroup::all();
    }

    public function view(): View
    {
        return view('exports.blood-groups', [
            'bloodGroups' => $this->bloodGroups
        ]);
    }
}
