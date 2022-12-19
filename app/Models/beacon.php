<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beacon extends Model
{
    use HasFactory;

    protected $table = 'beacons';

    protected $fillable = [
        'structure_id', 'system', 'name', 'constellation', 'region','expires_in',
    ];


}
