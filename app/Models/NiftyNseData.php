<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NiftyNseData extends Model
{
    use HasFactory;
    protected $fillable = [
        'nifty_expiry',
        'filtered_nifty_nse_data',
        'all_nifty_nse_data',
    ];
}
