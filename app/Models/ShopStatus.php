<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id',
        'status_name',
        'is_now_status'
    ];

    protected $guarded = [
        'id'
    ];

    public static $rules = [
        'status_id' => ['required', 'integer'],
        'status_name' => ['required', 'string'],
        'is_now_status' => ['required', 'boolean'],
    ];

}
