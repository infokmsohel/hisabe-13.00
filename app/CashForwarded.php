<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashForwarded extends Model
{
    protected $fillable = [
        'account_id','business_id','cash_forwarded'
    ];
}
