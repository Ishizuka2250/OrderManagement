<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaitNumber;
use App\Models\CardInformation;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

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
        
        # 次に発行する待ち番号を取得する
        $nextWaitingNumber = $this->getNextWaitingNo($request->key);
        
        if ($nextWaitingNumber < 1) {
            # 待ち番号取得中にエラーが発生した場合
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

        # 待ち番号発行 (順番飛ばしでタッチされた場合も考慮して発行)
        if ($this->issueWaitNumbers($nextWaitingNumber)) {
            return response()->json([
                'success' => 1,
                'wait_number' => WaitNumber::all(),
                'message' => 'Wait No issued -- ' . WaitNumber::all()->sortByDesc('waiting_no')->first()->waiting_no
            ], 201);
        } else {
            # 待ち番号発行に失敗した場合
            return response()->json([
                'success' => 0,
                'errorcode' => 7,
                'message' => 'Error: Failed to issue Waiting Number due to the Database Server.'
            ], 500);
        }
    }

    public function issueWaitNumbers(int $NextWaitingNumber)
    {
        $currentWaitingNo = $this->getCurrentWaitingNo();
        # 待ち番号発行 (順番飛ばしでタッチされた場合は間の番号も発行)
        for ($wn = $currentWaitingNo + 1; $wn <= $NextWaitingNumber; $wn++) {
            if (!$this->issueWaitNumber($wn)) return false;
        }
        return true;
    }

    public function issueWaitNumber(int $WaitingNumber)
    {
        # 引数で指定した待ち番号を発行する
        try {
            WaitNumber::create([
                'waiting_no' => $WaitingNumber,
                'card_id' => $this->getCardInfoFromWaitingNo($WaitingNumber)->id,
                'is_cut_wait' => true,
                'is_cut_done' => false,
                'is_cut_call' => false,
                'is_cut_now' => false,
            ]);
        } catch(\Exception $e) {
            return false;
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
        # $keyOrCardID -> カードID (Felica端末からタッチされた場合)
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
        # 待ち番号からカード情報レコードを取得
        $cardInfo = CardInformation::where('waiting_no', $WaitingNumber)->where('available', true)->first();
        if ($cardInfo !== null) {
            return $cardInfo;
        } else {
            return null;
        }
    }

    private function getCardInfoFromCardID(String $CardID) {
        # idmと一致するカード情報レコードを取得
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
            'key' => ['required', 'string']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 1,
                'message' => $validator->errors()
            ], 400);
        }
        $keyOrCardID = $request->key;
        $masterKeyUser = User::where('master_key', '=', $keyOrCardID)->first();
        
        # $keyOrCardID -> masterkey (ブラウザ操作の場合)
        if ($masterKeyUser !== null) {
            $validator = Validator::make($request->all(), [
                'waiting_numbers' => ['required', 'array']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'errorcode' => 2,
                    'message' => $validator->errors()
                ], 400);
            }
            
            $updateCount = $this->updateFromWebApplication($request->waiting_numbers);
        }
        # $keyOrCardID -> カードID (Felica端末からタッチされた場合)
        else {
            $updateCount = $this->updateFromFelicaCardTouch($keyOrCardID);
        }

        if ($updateCount < 0) {
            # 待ち番号の状態更新中にエラーが発生した場合
            $updateError = $updateCount;
            switch ($updateError) {
                case -1:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 3,
                        'message' => 'Error: waiting_numbers array is include unrecognizable value.'
                    ], 400);
                case -2:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 4,
                        'message' => 'Error: waiting_numbers array is include unexist id.'
                    ], 400);
                case -3:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 5,
                        'message' => 'Error: Mutable status is one state only.'
                    ], 400);
                case -4:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 6,
                        'message' => 'Error: Failed to issue Waiting Number due to the Database Server.'
                    ], 500);
                case -5:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 3,
                        'message' => 'Error: A Touched Felica Card is not registered in the Database.'
                    ], 400);
                case -6:
                    return response()->json([
                        'success' => 0,
                        'errorcode' => 4,
                        'message' => 'Error: The Felica Card is already touched.'
                    ], 400);
            }
        }

        # 待ち状態状態の更新成功
        return response()->json([
            'success' => 1,
            'update_count' => $updateCount,
            'message' => 'Waiting Numbers were update complete.'
        ], 200);
    }

    private function updateFromFelicaCardTouch(string $CardID)
    {
        $cardInfo = $this->getCardInfoFromCardID($CardID);
        # タッチされたカードがDBに登録されているか？
        if ($cardInfo === null) return -5;
        
        $waitingNumber = $cardInfo->waiting_no;
        # タッチされたカードが発行されているか？ or タッチされたカードの間のカードが発行されているか？
        # -> 発行されていなければ強制的に発行する
        $issueCheckResult = $this->waitingNumberIssuedCheck($waitingNumber);
        # 待ち番号の発行に失敗したか？
        if ($issueCheckResult < 0) return $issueCheckResult;

        # 待ち番号更新用のArrayを作成
        $updateStatusArray = $this->cardTouchUpdateArray($waitingNumber);
        $checkResult = $this->updateFormatCheck($updateStatusArray);
        if ($checkResult < 0) return $checkResult;

        # 待ち状態を更新
        $updateCount = $this->waitingNumberUpdate($updateStatusArray);

        return $updateCount;
    }

    private function waitingNumberIssuedCheck(int $WaitingNumber)
    {
        $waitNumberRecords = WaitNumber::all();
        for($wn = 1; $wn <= $WaitingNumber; $wn++) {
            # 待ち番号が発行されているかチェック
            $checkResult[$wn] = $this->waitingNumberExists($waitNumberRecords, $wn);
        }

        # $checkResultの結果を参照し、発行されていない待ち番号を発行する
        for ($wn = 1; $wn <= $WaitingNumber; $wn++) {
            if (! $checkResult[$wn]) {
                # 待ち番号の発行に失敗した場合
                if (! $this->issueWaitNumber($wn)) return -4;
            }
        }

        # 既にタッチされたカードか？
        $waitNumberRecord = WaitNumber::where('waiting_no', '=', $WaitingNumber)->get()[0];
        if (((int)$waitNumberRecord['is_cut_now'] === 1) || ((int)$waitNumberRecord['is_cut_done'] === 1)) return -6;

        return 0;
    }

    private function cardTouchUpdateArray(int $UpdateWaitingNumber)
    {
        $cardTouchWaitingNumberRecord = WaitNumber::where('waiting_no', '=', $UpdateWaitingNumber)->get();
        $cutNowStatusRecord = WaitNumber::where('is_cut_now', '=', 1)->get();
        $cutWaitStatusRecords = WaitNumber::where('is_cut_wait', '=', 1)->where('waiting_no', '<', $UpdateWaitingNumber)->get();
        
        # カット中の待ち番号をis_cut_doneへ変更する
        $updateStatusCollections = $this->getUpdateStatusCollection($cutNowStatusRecord, 'is_cut_done');
        # タッチされた待ち番号をis_cut_nowへ変更する
        $updateStatusCollections = $updateStatusCollections->merge($this->getUpdateStatusCollection($cardTouchWaitingNumberRecord, 'is_cut_now'));
        # タッチされた待ち番号より前の番号でis_cut_waitになっているレコードをis_cut_callへ変更する
        $updateStatusCollections = $updateStatusCollections->merge($this->getUpdateStatusCollection($cutWaitStatusRecords, 'is_cut_call'));

        return $updateStatusCollections->toArray();
    }

    private function getUpdateStatusCollection(Collection $WaitNumberRecords, string $UpdateStatus)
    {
        $updateStatusCollection = new Collection();
        foreach($WaitNumberRecords as $WaitNumberRecord) {
            # 一旦全部の状態を初期化
            $WaitNumberRecord['is_cut_wait'] = 0;
            $WaitNumberRecord['is_cut_done'] = 0;
            $WaitNumberRecord['is_cut_call'] = 0;
            $WaitNumberRecord['is_cut_now'] = 0;
            # 引数で指定した状態フラグを上げる
            $WaitNumberRecord[$UpdateStatus] = 1;
            $updateStatusCollection->add($WaitNumberRecord);
        }
        return $updateStatusCollection;
    }

    private function waitingNumberExists(Collection $WaitNumberRecords, int $WaitingNumber)
    {
        # 引数として与えられた待ち番号が発行されているか？
        foreach($WaitNumberRecords as $waitNumberRecord) {
            if ((int)$waitNumberRecord->waiting_no === $WaitingNumber) return true;
        }
        return false;
    }

    private function updateFromWebApplication(array $updateStatusArray)
    {
        # waiting_numbersのデータチェック
        $checkResult = $this->updateFormatCheck($updateStatusArray);
        if ($checkResult < 0) return $checkResult;
        
        # $UpdateWaitingNumbersに従ってレコードを更新
        $updateCount = $this->waitingNumberUpdate($updateStatusArray);
        return $updateCount;
    }

    private function updateFormatCheck(array $UpdateStatusArray)
    {
        foreach ($UpdateStatusArray as $updateStatusItem) {
            # waiting_numbersデータに対象のキーがセットされているか？
            if (! $this->arrayKeysExists(['id', 'is_cut_wait', 'is_cut_done', 'is_cut_call', 'is_cut_now'], $updateStatusItem)) return -1;
            # 変更対象のレコードが存在するか？
            if (WaitNumber::find($updateStatusItem['id']) === null) return -2;
            # 変更する待ち番号のステータスは1つだけか？
            $checkSum = 0;
            foreach(['is_cut_wait', 'is_cut_done', 'is_cut_call', 'is_cut_now'] as $key) $checkSum += $updateStatusItem[$key];
            if ($checkSum != 1) return -3;
        }
        return 0;
    }

    private function arrayKeysExists(array $CheckKeys, array $SearchArray)
    {
        # 引数として与えられたKey情報($CheckKeys)が確認の対象Array($SearchArray)にすべて含まれているか？
        foreach ($CheckKeys as $key) {
            if (!array_key_exists($key, $SearchArray)) return false;
        }
        return true;
    }

    private function waitingNumberUpdate(array $UpdateStatusArray)
    {
        $updateCount = 0;
        # 待ち番号の状態を更新
        foreach($UpdateStatusArray as $updateStatusItem) {
            $target = WaitNumber::find($updateStatusItem['id']);
            $target->is_cut_wait = $updateStatusItem['is_cut_wait'];
            $target->is_cut_done = $updateStatusItem['is_cut_done'];
            $target->is_cut_now = $updateStatusItem['is_cut_now'];
            $target->is_cut_call = $updateStatusItem['is_cut_call'];
            try {
                $target->save();
            } catch (\Exception $e) {
                # 対象データの更新に失敗した場合
                return -4;
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
