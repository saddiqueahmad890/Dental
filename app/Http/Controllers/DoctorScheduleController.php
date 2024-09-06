<?php

namespace App\Http\Controllers;
use App\Models\UserLogs;
use App\Traits\Loggable;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;

class DoctorScheduleController extends Controller
{
    use loggable;
    /**
     * Constructor
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('permission:doctor-schedule-read|doctor-schedule-create|doctor-schedule-update|doctor-schedule-delete', ['only' => ['index','show']]);
        $this->middleware('permission:doctor-schedule-create', ['only' => ['create','store']]);
        $this->middleware('permission:doctor-schedule-update', ['only' => ['edit','update']]);
        $this->middleware('permission:doctor-schedule-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->export) {
            return $this->doExport($request);
        }

        // Build the base query
        $doctorSchedulesQuery = DoctorSchedule::with(['user']);

        if (auth()->user()->hasRole('Doctor')) {
            $doctorSchedulesQuery->where('user_id', auth()->id());
        }

        // Filter by user_id if it's provided
        if ($request->has('userid')) {
            $doctorSchedulesQuery->where('user_id', $request->userid);
        }

        $doctorSchedules = $this->filter($request, $doctorSchedulesQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('doctor-schedule.index', compact('doctorSchedules'));
    }

    public function doExport(Request $request)
    {
        $doctorSchedulesQuery = $this->buildDoctorSchedulesQuery($request);
        $doctorSchedules = $this->filter($request, $doctorSchedulesQuery)->get();

        $data = $doctorSchedules->map(function ($schedule) {
            return [
                'ID' => $schedule->id,
                'Doctor Name' => $schedule->user->name ?? 'N/A',
                'Weekday' => $schedule->weekday,
                'Start Time' => $schedule->start_time,
                'End Time' => $schedule->end_time,
                'Avg Appointment Duration' => $schedule->avg_appointment_duration,
                'Serial Type' => $schedule->serial_type,
                'Status' => $schedule->status,
                'Created At' => $schedule->created_at,
                'Updated At' => $schedule->updated_at,
            ];
        })->toArray();

        $headers = [
            'ID', 'Doctor Name', 'Weekday', 'Start Time', 'End Time',
            'Avg Appointment Duration', 'Serial Type', 'Status', 'Created At', 'Updated At'
        ];

        return Excel::download(new GenericExport($data, $headers), 'DoctorSchedules.xlsx');
    }

    private function buildDoctorSchedulesQuery(Request $request)
    {
        $roleName = Auth::user()->getRoleNames();
        $doctorSchedulesQuery = DoctorSchedule::with(['user']);

        if ($roleName[0] == 'Doctor') {
            $id = Auth::user()->id;
            $doctorSchedulesQuery->where('user_id', $id);
        }

        return $doctorSchedulesQuery;
    }

    private function filter(Request $request, $query)
    {
        if ($request->name) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', $request->name . '%');
            });
        }

        if ($request->weekday) {
            $query->where('weekday', $request->weekday);
        }

        return $query;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFromDoctorDetails($userid)
    {
        $doctors = User::role('Doctor')->where('status', '1')->orderBy('created_at','desc')->get(['id', 'name']);
        $selectedDoctorId = $userid;
        return view('doctor-schedule.create', compact('doctors', 'selectedDoctorId'));
    }

    public function create()
    {
        $doctors = User::role('Doctor')->where('status', '1')->orderBy('created_at','desc')->get(['id', 'name']);

        return view('doctor-schedule.create', compact('doctors'));
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

        if ($request->weekday === 'Whole Week') {
            $weekdays = array_slice(config('constant.weekdays'), 0, 7); // Select all weekdays
        } else {
            $weekdays = [$request->weekday]; // Select only the chosen weekday
        }
        foreach ($weekdays as $day) {
            $doctorSchedule=DoctorSchedule::create([
                'user_id' => $request->user_id,
                'weekday' => $day,
                'created_by'=>auth()->id()

            ]);
        }
            return redirect()->route('doctor-schedules.edit', $doctorSchedule->id)->with('success', trans('Doctor Schedule Added Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorSchedule  $doctorSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorSchedule $doctorSchedule)
    {
        return view('doctor-schedule.show', compact('doctorSchedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorSchedule  $doctorSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(DoctorSchedule $doctorSchedule)
    {
        $doctors = User::role('Doctor')->where('status', '1')->orderBy('created_at','desc')->get(['id', 'name']);


        //start log code
        $logs = UserLogs::where('table_name', 'doctor_schedules')->orderBy('id', 'desc')
        ->with('user')
        ->paginate(10);
        //end log code

        return view('doctor-schedule.edit', compact('doctors', 'doctorSchedule','logs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorSchedule  $doctorSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DoctorSchedule $doctorSchedule)
    {
        $this->validation($request, $doctorSchedule->id);
        $data = $request->only(['user_id', 'weekday', 'status']);
        $data['updated_by'] = auth()->id();
        $doctorSchedule->update($data);

        return redirect()->route('doctor-schedules.index')->with('success', trans('Doctor Schedule Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorSchedule  $doctorSchedule
     * @return \Illuminate\Http\Response
     */
    // public function destroy(DoctorSchedule $doctorSchedule)
    // {
    //     $doctorSchedule->delete();
    //     return redirect()->route('doctor-schedules.index')->with('success', trans('Doctor Schedule Deleted Successfully'));
    // }
    public function destroy(Request $request, $id)
    {
        $doctorSchedule = DoctorSchedule::findOrFail($id);
        $doctorSchedule->delete();

        return redirect()->route('doctor-schedules.index')->with('success', 'Doctor schedule deleted successfully');
    }

    /**
     * Validation function
     *
     * @param Request $request
     * @return void
     */
    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'weekday' => ['required', 'in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Whole Week'],
        ]);
        $this->scheduleOverlapCheck($request, $id);
    }

    /**
     * Schedul ovlap validation check
     *
     * @param Request $request
     * @param integer $id
     * @return void
     */
    private function scheduleOverlapCheck(Request $request, $id = 0)
    {
        $overlap = DoctorSchedule::where('user_id', $request->user_id)
            ->where('weekday', $request->weekday);

        if ($id)
            $overlap->where('id', '<>', $id);

        if ($overlap->count())
            $this->validate(
                $request,
                [
                    'weekday' => 'image',
                ],
                [
                    'weekday.image' => 'Schedule overlaped',
                ]
            );
    }
}
