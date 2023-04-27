<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShopStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!ShopStatus::where('is_now_status', true)->exists()) {
            # 現在のステータスが設定されていない場合 -> Store Close状態に設定
            $closeStatus = ShopStatus::find(1);
            $closeStatus->is_now_status = true;
            $closeStatus->save();
            return response()->json([
                'success' => 1,
                'status_id' => 1,
                'message' => 'Info: Now Shop Status is ' . $closeStatus->status_name . '.'
            ], 200);
        }
        $changeShopStatus = ShopStatus::where('is_now_status', true)->first();
        return response()->json([
            'success' => 1,
            'status_id' => $changeShopStatus->id,
            'message' => 'Info: Now Shop Status is ' . $changeShopStatus->status_name . '.'
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
        //
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
        # status_idのバリデーションチェック
        $validator = Validator::make($request->all(), [
            'status_id' => ['required', 'integer'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errorcode' => 'EA0201',
                'message' => 'Error: ' . $validator->errors()
            ], 400);
        }
        # 店の状態を取得
        $oldShopStatus = ShopStatus::where('is_now_status', true)->first();
        if ($oldShopStatus->id == $request->status_id) {
            # 同じ状態で更新しようとした場合
            return response()->json([
                'success' => 0,
                'errorcode' => 'EA0202',
                'already_changed_status' => $oldShopStatus,
                'message' => 'Error: Shop Status already changed [' . $oldShopStatus->status_name  . ']'
            ], 400);
        }else {
            # 店状態を更新
            ShopStatus::where('is_now_status', true)->update(['is_now_status' => false]);
            ShopStatus::find($request->status_id)->fill(['is_now_status' => true])->save();
            $changeShopStatus = ShopStatus::where('is_now_status', true)->first();
            return response()->json([
                'success' => 1,
                'changed_status' => $changeShopStatus,
                'message' => 'Error: Shop Status changed [' . $oldShopStatus->status_name . ' -> ' . $changeShopStatus->status_name . ']'
            ], 200);
        }
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
