<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valor extends Model
{
    protected $table = 'valors';
    protected $fillable = [
        'id_deputado',
        'valorTotal',
        'nome',
        'mes'
    ];
}