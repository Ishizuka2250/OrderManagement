<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
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
            'wait_number' => WaitNumber::all(),
            'message' => 'Response the ' . WaitNumber::all()->count() . ' Wait No States.'
        ], 200);
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
        if ($waitNumber->all()->count() > 0) {
            $waitingNumber = WaitNumber::all()->sortByDesc('waiting_no')->first()->waiting_no + 1;
        }else{
            $waitingNumber = 1;
        }
        $waitNumber->create([
            'waiting_no' => $waitingNumber,
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'waiting_numbers' => ['required', 'array']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 1,
                'message' => $validator->errors()
            ], 400);
        }

        $updateCount = 0;
        foreach(request()->waiting_numbers as $waitNumber) {
            $target = WaitNumber::find($waitNumber['id']);
            $target->is_cut_wait = $waitNumber['is_cut_wait'];
            $target->is_cut_done = $waitNumber['is_cut_done'];
            $target->is_cut_now = $waitNumber['is_cut_now'];
            $target->is_cut_call = $waitNumber['is_cut_call'];
            $target->save();
            $updateCount++;
        }

        return response()->json([
            'success' => 1,
            'update_count' => $updateCount,
            'message' => 'Update OK.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => ['integer']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'The send parameter "id" is not integer.'
            ], 400);
        }
        $waitNumber = WaitNumber::all();
        if ($waitNumber->count() > 0) {
            if (!is_null($request->id)) {
                $number = WaitNumber::find($request->id);
                if (!is_null($number)) {
                    WaitNumber::destroy($request->id);
                    return response()->json([
                        'success' => 1,
                        'wait_number' => WaitNumber::all(),
                        'message' => 'The Waiting Number ' . $number->waiting_no . ' has been deleted.'
                    ], 200);
                }else{
                    return response()->json([
                        'success' => 0,
                        'message' => 'The Wait Number ID:' . $request->id . ' already deleted.'
                    ], 200);
                }
            } else {
                WaitNumber::truncate();
                return response()->json([
                    'success' => 1,
                    'message' => 'The All Wait Number has been deleted.'
                ], 200);
            }
        } else {
            return response()->json([
                'success' => 0,
                'message' => 'The All Wait Number already deleted.'
            ], 200);
        }

    }
}
