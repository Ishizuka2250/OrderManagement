<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CardInformation;
use Illuminate\Support\Facades\Validator;

class CardRegistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => ['string', 'size:16']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 'EA0401',
                'message' => 'Error: ' . $validator->errors()
            ]);
        }
        $key = $request->key;
        if (empty($key)) {
            return response()->json([
                'success' => 1,
                'card_information' => CardInformation::all(),
                'message' => 'Info: Response the ' . CardInformation::all()->count() . ' card information.'
            ]);
        } else {
            $cardInformation = CardInformation::where('idm', '=', $key)->get();
            return response()->json([
                'success' => 1,
                'card_information' => $cardInformation,
                'message' => 'Info: Response the ' . $cardInformation->count() . ' card information.'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => ['required', 'string', 'size:16']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 'EA0402',
                'message' => 'Error: ' . $validator->errors()
            ]);
        }

        $key = $request->key;
        if (CardInformation::where('idm', '=', $key)->exists()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 'EA0403',
                'message' => 'Error: The Felica Card is already registed in the Database.'
            ]);
        }
        
        $waiting_no = $this->createCardInformation($key);
        if ($waiting_no  > 0) {
            return response()->json([
                'success' => 1,
                'wait_number' => $waiting_no,
                'message' => 'Info: The Felica Card has registed in the Database.'
            ], 201);
        } else {
            return response()->json([
                'success' => 0,
                'errorcode' => 'EA0404',
                'message' => 'Error: Failed to regist the Felica Card due to the Database Server.'
            ], 500);
        }
    }

    public function createCardInformation(string $Key) {
        $waiting_no = $this->getNewWaitingNumber();
        try {
            CardInformation::create([
                'waiting_no' => $waiting_no,
                'idm' => $Key,
                'available' => 1
            ]);
        }catch (\Exception $e) {
            return -1;
        }
        return $waiting_no;
    }

    public function getNewWaitingNumber() {
        # waiting_no の最大値 + 1 を新しい待ち番号として返却
        return CardInformation::all()->sortByDesc('waiting_no')->first()->waiting_no + 1;
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
