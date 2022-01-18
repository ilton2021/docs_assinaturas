<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlterarSenha extends Model
{
    protected $table = 'alterar_senha';

    protected $fillable = [
        'token',
        'user_id',
        'updated_at',
        'created_at'
    ];
}
