<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankNiftyNseData extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank_nifty_expiry',
        'filtered_bank_nifty_nse_data',
        'all_bank_nifty_nse_data',
    ];
}
