<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FluxoAssinaturas extends Model
{
    protected $table = 'fluxo_assinaturas';

    protected $fillable = [
        'doc_id',
        'user_id',
        'fluxo',
        'created_at',
        'updated_at'
    ];
}
