<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherCourse;
use App\Models\Course;
use App\Models\UserLogs;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  function __construct()
    // {
    //     $this->middleware('permission:student-read|student-create|student-update|student-delete', ['only' => ['index','show']]);
    //     $this->middleware('permission:student-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:student-update', ['only' => ['edit','update']]);
    //     $this->middleware('permission:student-delete', ['only' => ['destroy']]);
    // }


    public function index()
    {
        $students = Student::paginate(10);
        return view('student.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = DB::select("select * from teachers");
        return view('student.create',['teachers'=>$teachers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);

        $data = $request->only(['name', 'department_id', 'teacher_id', 'course_id', 'address', 'dob']);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageName = $photo->getClientOriginalName();
            $photo->move('lara/student', $imageName);
            $data['photo'] = $imageName;
        }

        Student::create($data);
        return redirect()->route('student.index')->with('success', trans('Student Created Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('student.show',compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {




         $courses = Course::all();
         $teachers = DB::select("select * from teachers");
        return view('student.edit',compact('student','courses'),['teachers'=>$teachers]);

        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $this->validation($request, $student->id);

        $data = $request->only(['name', 'department_id','teacher_id','course_id', 'address','dob']);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $imageName = $photo->getClientOriginalName();
            $photo->move('lara/student', $imageName);
            $data['photo'] = $imageName;
        }
        $student->update($data);

        return redirect()->route('student.index')->with('success', trans('Student Updated Successfully'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('student.index')->with('success', trans('Student Deleted Successfully'));
    }


    public function fetchCourses(Request $request)
    {
        $teacherId = $request->teacher_id;

        $course = TeacherCourse::where('teacher_id', $teacherId)->pluck('course_id')->toArray();
        $courses = Course::whereIn('id', $course)->pluck('course_name','id');
        return response()->json($courses);
    }

    // public function fetchCourse(Request $request)
    // {
    //     $teacherId = $request->teacher_id;

    //     $course = TeacherCourse::where('teacher_id', $teacherId)->pluck('course_id')->toArray();
    //     $courses = Course::whereIn('id', $course)->pluck('course_name','id');
    //     return response()->json($courses);
    // }
    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'name' => ['required', 'unique:students,name,'.$id, 'string', 'max:255'],
            'department_id' => ['required', 'integer'], // Assuming department_id is an integer field
            'teacher_id' => ['required', 'integer'], // Assuming department_id is an integer field
            'course_id' => ['required', 'integer'], // Assuming department_id is an integer field
            'address' => ['required', 'string', 'max:1000'],
            'dob' => ['required', 'date'], // Assuming dob is a date field
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],

        ]);
    }
    public function upload(Request $request)
    {
        $request->validate([
            'files.*' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasfile('files')) {
            $fileNames = [];
            foreach ($request->file('files') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                 $file->move(public_path('uploads'), $name);


                $fileNames[] = $name;
            }

            return response()->json(['success' => true, 'files' => $fileNames]);
        }

        return response()->json(['success' => false], 400);
    }

    public function downloadFile(Request $request)
    {


        {
            $filename = $request->value1; // Assuming 'value1' contains the filename

            // Check if the file exists in the uploads directory
            $filePath = public_path('uploads/' . $filename);

            if (file_exists($filePath)) {
                // File exists, download it
                return response()->download($filePath);
            } else {
                // File not found, return error response
                return response()->json(['success' => false, 'error' => 'File not found'], 404);
            }
        }





    }
//     public function deleteFile(Request $request)
// {
//     try {
//         $filename = $request->input('filename');

//         $filePath = public_path('uploads/' . $filename);

//         if (file_exists($filePath) && is_file($filePath)) {
//             if (unlink($filePath)) {
//                 return response()->json(['success' => true]);
//             } else {
//                 return response()->json(['success' => false, 'error' => 'Unable to delete file'], 500);
//             }
//         } else {
//             return response()->json(['success' => false, 'error' => 'File not found or is not a file'], 404);
//         }
//     } catch (\Exception $e) {
//         return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
//     }
// }

 public function uploadFile(Request $request, $patientId) {
    $inputFields = ['cnic_file', 'insurance_card', 'other_files', 'profile_picture'];
    $response = ['success' => true, 'files' => [], 'errors' => []];

    foreach ($inputFields as $inputField) {
        if ($request->hasFile($inputField)) {
            foreach ($request->file($inputField) as $file) {
                // Generate the file name only once
                $fileName = $inputField . '_' . time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs("uploads/patient/{$patientId}/{$inputField}", $fileName);

                if ($filePath) {
                    // Check if input field is 'profile_picture' and delete existing profile picture
                    if ($inputField === 'profile_picture') {
                        $existingProfilePicture = File::where('record_id', $patientId)
                            ->where('record_type', 'profile_picture')
                            ->first();

                        if ($existingProfilePicture) {
                            // Delete existing profile picture from storage
                            Storage::delete("uploads/patient/{$patientId}/profile_picture/{$existingProfilePicture->file_name}");
                            // Delete existing profile picture record from the database
                            $existingProfilePicture->delete();
                        }
                    }

                    $fileRecord = new File();
                    $fileRecord->table_name ='students';
                    $fileRecord->record_id = $patientId;
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
public function getFiles($id) {
    $response = [
        'cnic_files' => [],
        'insurance_files' => [],
        'other_files' => [],
        'profile_picture' => null
    ];

    // Get all files for the patient from the database
    $files = File::where('record_id', $id)->get();

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

        if ($file->record_type === 'cnic_file') {
            $response['cnic_files'][] = $fileData;
        } elseif ($file->record_type === 'insurance_card') {
            $response['insurance_files'][] = $fileData;
        } elseif ($file->record_type === 'other_files') {
            $response['other_files'][] = $fileData;
        } elseif ($file->record_type === 'profile_picture') {
            $response['profile_picture'] = $fileData;
        }
    }

    return response()->json($response);
}

public function deleteFile(Request $request) {
    $fileName = $request->input('filePath');
    $fileType = $request->input('fileType');
    $patientId = $request->input('patientId');

    $directory = "uploads/patient/{$patientId}/{$fileType}";
    $filePath = $directory . '/' . $fileName;

    try {
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);

            File::where('file_name', $fileName)
                ->where('record_id', $patientId)
                ->where('record_type', $fileType)
                ->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => 'File not found.']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}

}
