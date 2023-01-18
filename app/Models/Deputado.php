<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deputado extends Model
{
    protected $table = 'deputados';

    protected $fillable = [
        'nome', 'nomeServidor', 'partido', 'endereco', 'telefone', 'fax', 'email', 'atividadeProfissional', 'naturalidadeMunicipio', 'naturalidadeUf', 'dataNascimento', 'redesSociais'
    ];
}