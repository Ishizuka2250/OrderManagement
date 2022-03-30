<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaitNumber;

class WaitNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success' => 1,
            'wait_number' => WaitNumber::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $waitNumber = new WaitNumber;
        $waitNumber->create([
            'waiting_no' => WaitNumber::all()->sortByDesc('waiting_no')->first()->waiting_no + 1,
            'is_cut_wait' => true,
            'is_cut_done' => false,
            'is_cut_call' => false,
            'is_cut_now' => false,
        ]);
        return response()->json([
            'success' => 1,
            'wait_number' => WaitNumber::all(),
            'message' => 'Wait No issued -- ' . WaitNumber::all()->sortByDesc('waiting_no')->first()->waiting_no
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
