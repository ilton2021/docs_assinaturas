<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'nome',
        'numeroDoc',
        'ordem',
        'caminho',
        'tipo',
        'solicitante_id',
        'fornecedor_id',
        'unidade_id',
        'gestor_id',
        'aprovada',
        'concluida',
        'created_at',
        'updated_at'
    ];
}
