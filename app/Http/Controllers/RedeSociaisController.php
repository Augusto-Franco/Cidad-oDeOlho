<?php

namespace App\Http\Controllers;

use App\Models\Deputado;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RedeSociaisController extends Controller
{
    public function index()
    {
        $response = Http::get('http://dadosabertos.almg.gov.br/ws/deputados/lista_telefonica?formato=json');
        $deputados = $response->json()['list'];

        foreach ($deputados as $deputado) {
            $data = [];
            $data['nome'] = isset($deputado['nome']) ? $deputado['nome'] : null;
            $data['nomeServidor'] = isset($deputado['nomeServidor']) ? $deputado['nomeServidor'] : null;
            $data['partido'] = isset($deputado['partido']) ? $deputado['partido'] : null;
            $data['endereco'] = isset($deputado['endereco']) ? $deputado['endereco'] : null;
            $data['telefone'] = isset($deputado['telefone']) ? $deputado['telefone'] : null;
            $data['fax'] = isset($deputado['fax']) ? $deputado['fax'] : null;
            $data['email'] = isset($deputado['email']) ? $deputado['email'] : null;
            $data['atividadeProfissional'] = isset($deputado['atividadeProfissional']) ? $deputado['atividadeProfissional'] : null;
            $data['naturalidadeMunicipio'] = isset($deputado['naturalidadeMunicipio']) ? $deputado['naturalidadeMunicipio'] : null;
            $data['naturalidadeUf'] = isset($deputado['naturalidadeUf']) ? $deputado['naturalidadeUf'] : null;
            $data['dataNascimento'] = isset($deputado['dataNascimento']) ? $deputado['dataNascimento'] : null;
            $data['redesSociais'] = isset($deputado['redesSociaiais']) ? json_encode($deputado['redesSociais']) : null;
            Deputado::firstOrCreate(['nome' => $data['nome']], $data);
        }
        
            }
            }
