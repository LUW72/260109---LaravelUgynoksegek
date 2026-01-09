<?php

namespace App\Http\Controllers;

use App\Models\Participate;
use Illuminate\Http\Request;

class ParticipateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Participate::query()->orderBy('date', 'desc')->get()
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Participate $participate)
    {
        return response()->json($participate);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participate $participate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participate $participate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participate $participate)
    {
        //
    }


    public function cancelToday(Request $request)
    {
        $userId = $request->user()->user_id ?? $request->user()->id;

        $updated = Participate::query()
            ->where('user_id', $userId)
            ->whereHas('event', function ($q) {
                $q->whereDate('date', today())
                ->where('status', 0);
            })
            ->update(['present' => false]);

        return response()->json([
            'message' => 'Participation cancelled for today (where applicable).',
            'updated' => $updated
        ]);
    }    
}
