<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NseData extends Model
{
    use HasFactory;

    protected $fillable = [
        'expiry',
        'filtered_nse_data',
        'all_nse_data',
    ];
}
