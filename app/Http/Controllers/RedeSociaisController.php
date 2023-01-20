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
        //Faz uma requisição para a API, a resposta é convertida em um array e armazena a lista de deputados na variável $deputados.
        $response = Http::get('http://dadosabertos.almg.gov.br/ws/deputados/lista_telefonica?formato=json');
        $deputados = $response->json()['list'];

        //Percorre o array de deputados e para cada deputado cria um array $data e adiciona os valores. Depois verifica se já existe um deputado com o mesmo id e se não tiver salva os dados no banco de dados.
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

        //Armazena as redes sociais dos deputados em uma tabela diferente do banco de dados.
        foreach ($deputados as $deputado) {
            if (isset($deputado['redesSociais'])) {
                foreach ($deputado['redesSociais'] as $redeSocial) {
                    $data = [];
                    $data['url'] = $redeSocial['url'];
                    RedeSociais::firstOrcreate(['url' => $data['url']], $data);
                }
            }
        }
        
        //Lista as redes sociais mais usadas  e coloca um redirecionamento para a outra view.
        $this->listarRedesSociaisMaisUsadas();
        echo '<a href="http://127.0.0.1:8000/deputados"><br>Deputados que mais pediram reembolso de verbas indenizatórias por mês em 2019</a>';
    }

    public function listarRedesSociaisMaisUsadas()
    {
        //Cria um vetor com os nomes das redes sociais e outro array que é preenchido com o valor 0 para o nome de cada rede social.
        $redesSociais = ["facebook", "instagram", "twitter", "youtube", "whatsapp", "soundcloud", "flickr", "linkedin"];
    $contagemRedesSociais = array_fill_keys($redesSociais, 0);

    $urls = RedeSociais::all();

    //Separa apenas o nome da rede social de cada url e para o nome de cada rede social o vetor $contagemRedesSociais incrementa o valor da rede social correspondente.
    foreach ($urls as $url) {
        foreach ($redesSociais as $redeSocial) {
            $contagemRedesSociais[$redeSocial] += substr_count(strtolower($url->url), strtolower($redeSocial));
        }
    }

    //Ordena as redes sociais por ordem de ocorrência.
    arsort($contagemRedesSociais);

    foreach ($contagemRedesSociais as $redeSocial => $count) {
        echo "A rede social " . $redeSocial . " foi usada " . $count . " vezes entre os deputados. <br>";
    }
        }
    }