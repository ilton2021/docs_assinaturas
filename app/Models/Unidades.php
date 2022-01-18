<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidades extends Model
{
    protected $table = 'unidades';

    protected $fillable = [
        'nome',
        'imagem',
        'caminho',
        'sigla',
        'created_at',
        'updated_at'
    ];
}
