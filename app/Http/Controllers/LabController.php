<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\User;
use App\Models\Lab;
use App\Models\HospitalDepartment;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\UserLogs;

use Maatwebsite\Excel\Facades\Excel;

class LabController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:labs-read|labs-create|labs-update|labs-delete', ['only' => ['index','show']]);
        $this->middleware('permission:labs-create', ['only' => ['create','store']]);
        $this->middleware('permission:labs-update', ['only' => ['edit','update']]);
        $this->middleware('permission:labs-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if ($request->export)
            return $this->doExport($request);
        $labs = $this->filter($request)->with('user')->orderBy('id', 'desc')->paginate(10);
        return view('lab.index', compact('labs'));
    }
    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new UserExport($request, 'Lab'), 'Labs.xlsx');
    }

    /**
     * Filter function
     *
     * @param Request $request
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function filter(Request $request)
    {
        $query = Lab::query();

        if ($request->has('lab_number')) {
            $query->where('lab_number', 'like', $request->input('lab_number') . '%');
        }
        if ($request->has('title')) {
            $query->where('title', 'like', $request->input('title') . '%');
        }

        if ($request->has('phone_no')) {
            $query->where('phone_no', 'like', $request->input('phone_no') . '%');
        }
        if ($request->has('address')) {
            $query->where('address', 'like', $request->input('address') . '%');
        }

        return $query;
    }

    /**
     * Get active doctor list
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Laboratorist']);
        })->get();


        return view('lab.create', compact('users'));
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


        $userData = $request->only(['name', 'email', 'PhoneNumber', 'address']);
        $userData['company_id'] = session('company_id');
        $userData['password'] = bcrypt($request->password);

        $user = User::create($userData);
        $role = Role::where('name', 'Laboratorist')->first();
        $user->assignRole([$role->id]);
        $user->save();

        $data = $request->only(['Title', 'Description',  'PhoneNumber', 'Address', 'lab_number']);

        $lab = new Lab();
        $lab->title = $data['Title'];
        $lab->user_id = $user['id'];
        $lab->description = $data['Description'];
        $lab->phone_no = $data['PhoneNumber'];
        $lab->address = $data['Address'];
        $lab->created_by = auth()->id();
        $lab->save();
        $lab->lab_number = getDocNumber($lab->id, 'LB');
        $lab->save();





        return redirect()->route('labs.edit', $lab->id)->with('success', __('Lab created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function show(Lab $lab)
    {
        return view('lab.show', compact('lab'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function edit(Lab $lab)

    {
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Laboratorist']);
        })->get();

        return view('lab.edit', compact('lab', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lab $lab)
    {
        $request->validate([]);

        $lab->title = $request->input('Title');
        $lab->description = $request->input('Description');
        // $lab->user_id = $request->input('user'); // Assign 'user' instead of 'user_id'
        $lab->phone_no = $request->input('PhoneNumber');
        $lab->address = $request->input('Address');
        $lab->updated_by = auth()->id();
        $lab->save();
        return redirect()->route('labs.edit', $lab->id)->with('success', __('Lab updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Lab $lab)
    {
        try {
            // Delete the lab record
            $lab->delete();

            return redirect()->route('labs.index')->with('success', __('Lab deleted successfully.'));
        } catch (\Exception $e) {
            return redirect()->route('labs.index')->with('error', __('Failed to delete lab.'));
        }
    }

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $id, 'max:255'],
            'PhoneNumber' => ['required', 'string', 'max:14'],
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'PhoneNumber' => 'nullable|string|max:20',
            'Address' => 'nullable|string|max:255',
        ]);
        if (empty($id)) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'max:255']
            ]);
        } else {
            $request->validate([
                'password' => ['nullable', 'string', 'min:8', 'max:255']
            ]);
        }
    }
}
