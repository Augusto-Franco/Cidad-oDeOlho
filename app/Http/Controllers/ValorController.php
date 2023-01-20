<?php

//O código abaixo só "funciona" se a página das redes sociais já tiver sido acessada.

namespace App\Http\Controllers;

use App\Models\Deputado;
use App\Models\Valor;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

set_time_limit(0);

class ValorController extends Controller
{
    public function salvarValor()
    {
        //Recupera todos os deputados do banco de dados e define os meses. 
        $deputados = Deputado::all();
        $meses = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        foreach ($deputados as $deputado) {
            foreach ($meses as $mes) {
                 //Faz uma requisição para a API, a resposta é armazenada na variável $response e depois convertida para json e armazenada em $verbas.
                $response = Http::get("http://dadosabertos.almg.gov.br/ws/prestacao_contas/verbas_indenizatorias/legislatura_atual/deputados/$deputado->id/2019/$mes?formato=json");
                $verbas = $response->json();

                //Garante que $verbas tem dados antes de prosseguir.
                if(isset($verbas['list'])){

                    //Armazena o valor de list em $verbas. É feito um loop através do objeto $verbas, e para cada objeto dentro dele, é pego o valor contido na chave 'valor' e adicionado à variável $valorTotal.
                    $verbas = $response->json()['list'];
                    $valorTotal = 0.0;
                    foreach ($verbas as $verba) {
                        $valorTotal += (double) $verba['valor'];
                    }

                    $verificaDuplicidade = Valor::where([
                        ['id_deputado', $deputado->id],
                        ['mes', $mes],
                    ])->first();

                    if(!$verificaDuplicidade) {
                        $valor = new Valor();
                        $valor->id_deputado = $deputado->id;
                        $valor->valorTotal = $valorTotal;
                        $valor->nome = $deputado->nome;
                        $valor->mes = $mes;
                        $valor->save();
                    }
                }
            }
        }
        //Lista os deputados que mais reembolsaram verbas em cada mês e coloca um redirecionamento para a outra view.
        self::topCincoDeputadosPorMes();
        echo '<a href="http://127.0.0.1:8000/"><br>Redes sociais mais usadas entre os deputados.</a>';
    }

    public function topCincoDeputadosPorMes()
    {
        for ($mes = 1; $mes <= 12; $mes++) {
            $topCinco = Valor::select('nome', 'valorTotal')->where('mes', $mes)->orderBy('valorTotal', 'desc')->take(5)->get();
            echo "Top 5 deputados do mês $mes: <br>";
            foreach ($topCinco as $deputado) {
                echo $deputado->nome . " - R$ " . $deputado->valorTotal . "<br>";
            }
            echo "<br>";
        }
    }
}