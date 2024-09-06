<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    /**
     * Show the calendar view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('calendar'); // Ensure you have a calendar.blade.php view
    }

    /**
     * Load events within a specified date range.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function loadEvents(Request $request): JsonResponse
    // {
    //     $start = $request->start;
    //     $end = $request->end;

    //     $events = Event::whereBetween('start_date', [$start, $end])
    //         ->orWhereBetween('end_date', [$start, $end])
    //         ->get();

    //     return response()->json($events);
    // }
    public function loadEvents(Request $request): JsonResponse
{
    $start = $request->start;
    $end = $request->end;
    $doctorId = auth()->user()->id; // Assuming the doctor's ID is stored in the logged-in user
    if ($doctorId == 1) {
        // Show all events if the doctor_id is 1
        $events = Event::where(function($query) use ($start, $end) {
                $query->whereBetween('start_date', [$start, $end])
                      ->orWhereBetween('end_date', [$start, $end]);
            })
            ->orwhere('eventtype', 'manual') // Include manual events
            ->get();
    } else {
    $events = Event::where(function($query) use ($start, $end) {
            $query->whereBetween('start_date', [$start, $end])
                  ->orWhereBetween('end_date', [$start, $end]);
        })
        ->where('doctor_id', $doctorId) // Filter by doctor_id
        ->orwhere('task_assign_to', $doctorId) // Filter by doctor_id
        ->orwhere('patient_id', $doctorId) // Filter by doctor_id
        ->orwhere('eventtype', 'manual') // Filter by eventType
        ->get();
    }

    return response()->json($events);
}


    /**
     * Store a newly created event.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);

        // Determine the event type
        $eventType = $request->has('appointment') ? 'appointment' : 'manual';

        // Add the event type to validated data
        $validatedData['eventtype'] = $eventType;

        Event::create($validatedData);

        return 1;

        // return redirect()->route('events.index')->with('success', 'Event Created Successfully');
    }

    /**
     * Show the details of a specific event.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        return response()->json($event);
    }

    /**
     * Update a specific event.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);

        $event = Event::findOrFail($id);
        $event->update($validatedData);

        return response()->json($event, 200);
    }

    /**
     * Remove a specific event.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['success' => 'Event deleted successfully'], 200);
    }
}
