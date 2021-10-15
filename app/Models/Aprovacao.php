<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aprovacao extends Model
{
    protected $table = 'aprovacao';

    protected $fillable = [
        'observacao',
        'ativo',
        'data_aprovacao',
        'data_prevista',
        'documento_id',
        'gestor_id',
        'gestor_anterior_id',
        'unidade_id',
        'fluxo',
        'created_at',
        'updated_at'
    ];
}
