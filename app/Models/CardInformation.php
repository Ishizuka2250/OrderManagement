<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'waiting_no',
        'idm',
        'available'
    ];

    protected $guarded = [
        'id'
    ];

    protected $rules = [
        'waiting_no' => ['required', 'integer'],
        'idm' => ['required', 'string'],
        'available' => ['required', 'boolean']
    ];
}
