<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseUpdateController extends Controller
{
public function applyChanges()
{
    try {
        // Apply the changes to the database
        DB::statement("");
   

        // Return the data as JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Database changes applied successfully.',
        ]);
    } catch (\Exception $e) {
        // Return the actual error message for debugging
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to apply database changes: ' . $e->getMessage()
        ], 500);
    }
}


}
