<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respostas extends Model
{
    protected $table = 'respostas';

    protected $fillable = [
        'descricao',
        'funcao_id',
        'created_at',
        'updated_at'
    ];
}
