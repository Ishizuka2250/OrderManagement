<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaitNumber;
use App\Models\CardInformation;
use App\Models\User;
use Exception;


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

    /**z
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 1,
                'message' => $validator->errors()
            ], 400);
        }

        
        $nextWaitingNumber = $this->getNextWaitingNo($request->key);
        
        if ($nextWaitingNumber < 1) {
            $issueError = $nextWaitingNumber;
            switch ($issueError) {
                case -1:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 2,
                        'message' => 'Error: Authorization a master_key but not registered the Felica Card.'
                    ], 400);
                case -2:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 3,
                        'message' => 'Error: A Touched Felica Card is not registered in the Database.'
                    ], 400);
                case -3:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 4,
                        'message' => 'Error: The Felica Card is already touched.'
                    ], 400);
                case -4:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 5,
                        'message' => 'Error: A Touched Felica Card or number card in between is not registered in the Database.'
                    ], 400);
                default:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 6,
                        'message' => 'Error: Failed to issue waiting number.'
                    ], 400);
            }
        }

        if ($this->issueWaitNumber($nextWaitingNumber)) {
            return response()->json([
                'success' => 1,
                'wait_number' => WaitNumber::all(),
                'message' => 'Wait No issued -- ' . WaitNumber::all()->sortByDesc('waiting_no')->first()->waiting_no
            ], 201);
        } else {
            return response()->json([
                'success' => 0,
                'errorcode' => 7,
                'message' => 'Error: Failed to issue Waiting Number due to the Database Server'
            ], 500);
        }
    }

    public function issueWaitNumber(int $NextWaitingNumber)
    {
        $currentWaitingNo = $this->getCurrentWaitingNo();
        for ($wn = $currentWaitingNo + 1; $wn <= $NextWaitingNumber; $wn++) {
            try {
                # 待ち番号発行 (順番飛ばしでタッチされた場合は間の番号も発行)
                WaitNumber::create([
                    'waiting_no' => $wn,
                    'card_id' => $this->getCardInfoFromWaitingNo($wn)->id,
                    'is_cut_wait' => true,
                    'is_cut_done' => false,
                    'is_cut_call' => false,
                    'is_cut_now' => false,
                ]);
            } catch(\Exception $e) {
                return false;
            }
        }
        return true;
    }

    public function getCurrentWaitingNo()
    {
        return WaitNumber::all()->count();
    }

    public function getNextWaitingNo(String $keyOrCardID)
    {
        # $keyOrCardID -> masterkey (ブラウザ操作の場合)
        $masterKeyUser = User::where('master_key', '=', $keyOrCardID)->first();
        if ($masterKeyUser !== null) {
            if (WaitNumber::all()->count() > 0) {
                $waitingNumber = WaitNumber::all()->sortByDesc('waiting_no')->first()->waiting_no + 1;
            } else {
                $waitingNumber = 1;
            }
            
            $cardInfo = $this->getCardInfoFromWaitingNo((int)$waitingNumber);
            if ($cardInfo === null) {
                return -1;
            } else {
                return $waitingNumber;
            }
        }
        # $key -> カードID (Felica端末からタッチされた場合)
        else{
            $cardInfo = $this->getCardInfoFromCardID((string)$keyOrCardID);
            
            # タッチされたカードがDBに登録されているか？
            if ($cardInfo === null) return -2;
            
            $currentWaitingNo = $this->getCurrentWaitingNo();
            $nextWaitingNo = $cardInfo->waiting_no;
            
            # 既にタッチされたカードか？
            if ($currentWaitingNo >= $nextWaitingNo) return -3;
            
            # タッチされたカードが間飛ばしの可能性も考慮して確認
            for ($wn = $currentWaitingNo + 1; $wn <= $nextWaitingNo; $wn++) {
                # タッチされたカード・その間のカードはDBに登録されているか？
                if ($this->getCardInfoFromWaitingNo($wn) === null) return -4;
            }

            return $nextWaitingNo;
        }
    }

    private function getCardInfoFromWaitingNo(Int $WaitingNumber) {
        $cardInfo = CardInformation::where('waiting_no', $WaitingNumber)->where('available', true)->first();
        if ($cardInfo !== null) {
            return $cardInfo;
        } else {
            return null;
        }
    }

    private function getCardInfoFromCardID(String $CardID) {
        $cardInfo = CardInformation::where('idm', '=' , $CardID)->where('available', true)->first();
        if ($cardInfo !== null) {
            return $cardInfo;
        } else {
            return null;
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

        $updateCount = $this->waitnumberUpdate(request()->waiting_numbers);

        if ($updateCount > -1) {
            return response()->json([
                'success' => 1,
                'update_count' => $updateCount,
                'message' => 'Update OK.'
            ], 200);
        } else {
            return response()->json([
                'success' => 0,
                'errorcode' => 1,
                'message' => 'Error: Failed to update Waiting Number.'
            ], 500);
        }
    }

    private function waitnumberUpdate($WaitingNumbers) {
        $updateCount = 0;
        foreach($WaitingNumbers as $waitNumber) {
            $target = WaitNumber::find($waitNumber['id']);
            $target->is_cut_wait = $waitNumber['is_cut_wait'];
            $target->is_cut_done = $waitNumber['is_cut_done'];
            $target->is_cut_now = $waitNumber['is_cut_now'];
            $target->is_cut_call = $waitNumber['is_cut_call'];
            try {
                $target->save();
            } catch (\Exception $e) {
                return -1;
            }
            $updateCount++;
        }
        return $updateCount;
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
