<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Event::query()->orderBy('date', 'desc')->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'agency_id' => ['required', 'integer', 'exists:agencies,id'],
            'name'      => ['required', 'string', 'max:255'],
            'limit'     => ['required', 'integer', 'min:1'],
            'type'      => ['required', 'string', 'max:50'],
            'date'      => ['required', 'date'],
            'location'  => ['required', 'string', 'max:255'],
            'status'    => ['sometimes', 'integer', 'in:0,1,2'],
        ]);

        $event = Event::create($data);

        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return response()->json($event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'agency_id' => ['sometimes', 'required', 'integer', 'exists:agencies,id'],
            'name'      => ['sometimes', 'required', 'string', 'max:255'],
            'limit'     => ['sometimes', 'required', 'integer', 'min:1'],
            'type'      => ['sometimes', 'required', 'string', 'max:50'],
            'date'      => ['sometimes', 'required', 'date'],
            'location'  => ['sometimes', 'required', 'string', 'max:255'],
            'status'    => ['sometimes', 'required', 'integer', 'in:0,1,2'],
        ]);

        $event->update($data);

        return response()->json($event->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }

    public function expireOldEvents()
    {
        $updated = Event::query()
            ->where('date', '<=', now()->subWeeks(3))
            ->where('status', '!=', 1)   
            ->update(['status' => 2]);

        return response()->json([$updated]);
    }    
}
