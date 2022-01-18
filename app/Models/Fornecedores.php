<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedores extends Model
{
    protected $table = 'fornecedores';

    protected $fillable = [
        'nome',
        'tipo_contrato',
        'tipo_pessoa',
        'cnpj_cpf',
        'email',
        'created_at',
        'updated_at'
    ];
}
