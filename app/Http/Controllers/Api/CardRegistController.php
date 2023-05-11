<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CardInformation;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;

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
            ], 400);
        }
        $key = $request->key;
        if (empty($key)) {
            $cardInformation = CardInformation::all();
            return response()->json([
                'success' => 1,
                'count' => $cardInformation->count(),
                'card_information' => $cardInformation,
                'message' => 'Info: Response the ' . $cardInformation->count() . ' card information.'
            ], 200);
        } else {
            $cardInformation = CardInformation::where('idm', '=', $key)->get();
            return response()->json([
                'success' => 1,
                'count' => $cardInformation->count(),
                'card_information' => $cardInformation,
                'message' => 'Info: Response the ' . $cardInformation->count() . ' card information.'
            ], 200);
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
            ], 400);
        }

        $key = $request->key;
        if (CardInformation::where('idm', '=', $key)->exists()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 'EA0403',
                'message' => 'Error: The Felica Card is already registed in the Database.'
            ], 400);
        }
        
        $cardInformation = $this->createCardInformation($key);
        if (!is_null($cardInformation)) {
            return response()->json([
                'success' => 1,
                'card_information' => $cardInformation,
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
            $createdCardInformation = CardInformation::create([
                'waiting_no' => $waiting_no,
                'idm' => $Key,
                'available' => 1
            ]);
        }catch (\Exception $e) {
            return null;
        }
        return $createdCardInformation;
    }

    public function getNewWaitingNumber() {
        $cardInformationCollection = CardInformation::all();
        if ($cardInformationCollection->count() > 0) {
            # waiting_no の最大値 + 1 を新しい待ち番号として返却
            return CardInformation::all()->sortByDesc('waiting_no')->first()->waiting_no + 1;
        } else {
            return 1;
        }
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
