<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loggers extends Model
{
    protected $table = 'loggers';

    protected $fillable = [
        'acao',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
