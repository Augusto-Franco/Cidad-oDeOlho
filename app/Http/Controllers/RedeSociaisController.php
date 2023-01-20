<?php

namespace App\Http\Controllers;

use App\Models\Deputado;
use App\Models\RedeSociais;
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
            $data['id'] = isset($deputado['id']) ? $deputado['id'] : null;
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
            Deputado::firstOrCreate(['id' => $data['id']], $data);
        }

        foreach ($deputados as $deputado) {
            if (isset($deputado['redesSociais'])) {
                foreach ($deputado['redesSociais'] as $redeSocial) {
                    $data = [];
                    $data['url'] = $redeSocial['url'];
                    RedeSociais::firstOrcreate(['url' => $data['url']], $data);
                }
            }
        }
        
        $this->listarRedesSociaisMaisUsadas();
        echo '<a href="http://127.0.0.1:8000/deputados"><br>Deputados que mais pediram reembolso de verbas indenizatórias por mês em 2019</a>';
    }

    public function listarRedesSociaisMaisUsadas()
    {
        $redesSociais = ["facebook", "instagram", "twitter", "youtube", "whatsapp", "soundcloud", "flickr", "linkedin"];
    $contagemRedesSociais = array_fill_keys($redesSociais, 0);

    $urls = RedeSociais::all();

    foreach ($urls as $url) {
        foreach ($redesSociais as $redeSocial) {
            $contagemRedesSociais[$redeSocial] += substr_count(strtolower($url->url), strtolower($redeSocial));
        }
    }

    arsort($contagemRedesSociais);

    foreach ($contagemRedesSociais as $redeSocial => $count) {
        echo "A rede social " . $redeSocial . " foi usada " . $count . " vezes entre os deputados. <br>";
    }
        }
    }