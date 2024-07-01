<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerprintModel extends Model
{
    protected $fillable = [
        'employee_id',
        'fingerprint_data',
        'template',
    ];

}
