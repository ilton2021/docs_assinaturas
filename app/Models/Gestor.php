<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestor extends Model
{
    protected $table = 'gestor';

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'matricula',
        'carimbo',
        'caminho',
        'cargo_id',
        'funcao_id',
        'unidade_id',
        'user_id',
        'gestor_imediato_id',
        'created_at',
        'updated_at'
    ];
}
