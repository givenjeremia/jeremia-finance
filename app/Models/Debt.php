<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'person_name',
        'amount',
        'due_date',
        'is_paid',
    ];
}
