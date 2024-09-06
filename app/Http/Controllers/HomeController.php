<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\File;


/**
 * Class HomeController
 * @package App\Http\Controllers
 * @category Controller
 */
class HomeController extends Controller
{
    /**
     * load constructor method
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard
     *
     * @access public
     * @return mixed
     */
    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function uploadFile(Request $request) {
        $tableName = $request->table_name;
        $recordId = $request->record_id;
        $inputFields = $request->input('input_fields', []);
        $response = ['success' => true, 'files' => [], 'errors' => []];

        foreach ($inputFields as $inputField) {
            if ($request->hasFile($inputField)) {
                foreach ($request->file($inputField) as $file) {
                    $uniqueId = uniqid();
                    $fileName = $inputField . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();

                    if ($inputField == 'teeth_files') {
                        $filePath = $file->storeAs("uploads/{$tableName}/{$recordId}/{$request->Childtable}/{$request->examinationId}/{$request->toothNumber}", $fileName);
                        $fileTableName = $request->Childtable;
                        $fileRecordId = $request->examinationId;
                        $child_table = 'teeth_files';
                        $tooth=$request->toothNumber;
                    } else {
                        $filePath = $file->storeAs("uploads/{$tableName}/{$recordId}/{$inputField}", $fileName);
                        $fileTableName = $tableName;
                        $fileRecordId = $recordId;
                        $child_table=null;
                        $tooth=null;


                    }

                    if ($filePath) {
                        // Check if input field is 'profile_picture' and delete existing profile picture
                        if ($inputField === 'profile_picture') {
                            $existingProfilePicture = File::where('record_id', $recordId)
                                ->where('record_type', 'profile_picture')
                                ->first();

                            if ($existingProfilePicture) {
                                // Delete existing profile picture from storage
                                Storage::delete("uploads/{$tableName}/{$recordId}/profile_picture/{$existingProfilePicture->file_name}");
                                // Delete existing profile picture record from the database
                                $existingProfilePicture->delete();
                            }
                        }

                        $fileRecord = new File();
                        $fileRecord->table_name = $fileTableName;
                        $fileRecord->child_table_name = $child_table;
                        $fileRecord->record_id = $fileRecordId;
                        $fileRecord->child_record_id = $tooth;
                        $fileRecord->record_type = $inputField;
                        $fileRecord->file_name = $fileName;
                        $fileRecord->created_by = auth()->user()->id;
                        $fileRecord->save();

                        $response['files'][] = [
                            'file_name' => $fileName,
                            'file_path' => $filePath,
                            'record_type' => $inputField,
                            'created_at' => now(),
                            'created_by' => auth()->user()->name
                        ];
                    } else {
                        $response['errors'][] = "Failed to store file: " . $file->getClientOriginalName();
                    }
                }
            }
        }

        if (!empty($response['errors'])) {
            $response['success'] = false;
        }

        return response()->json($response);
    }


    public function getFiles(Request $request, $id) {
        $tableName = $request->query('table_name'); // Expecting 'module' to be provided in the request
        $response = [
            'files' => []
        ];

        // Get all files for the record from the database
        $files = File::where('record_id', $id)->where('table_name', $tableName)->get();

        // Get all unique user IDs from the files
        $userIds = $files->pluck('created_by')->unique();

        // Fetch all users that are referenced in the files
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        // Group files by type
        foreach ($files as $file) {
            $fileData = [
                'file_name' => $file->file_name,
                'uploaded_by' => isset($users[$file->created_by]) ? $users[$file->created_by]->name : 'Unknown',
                'uploaded_at' => $file->created_at->format('Y-m-d H:i:s')
            ];

            if (!isset($response['files'][$file->record_type])) {
                $response['files'][$file->record_type] = [];
            }

            $response['files'][$file->record_type][] = $fileData;
        }

        return response()->json($response);
    }

    public function deleteFile(Request $request) {
        $fileName = $request->input('fileName');
        $fileType = $request->input('fileType');
        $recordId = $request->input('recordId');
        $tableName = $request->input('table_name');


        $directory = "uploads/{$tableName}/{$recordId}/{$fileType}";
        $filePath = $directory . '/' . $fileName;

        try {
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);

                File::where('file_name', $fileName)
                    ->where('record_id', $recordId)
                    ->where('record_type', $fileType)
                    ->delete();

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'error' => 'File not found from Controller.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }




    public function lang(Request $request)
    {
        $locale = $request->language;
        App::setLocale($locale);
        session()->put('locale', $locale);
        $user = auth()->user();
        if ($user)
            $user->update(['locale' => $locale]);

        return redirect()->back();
    }
}
