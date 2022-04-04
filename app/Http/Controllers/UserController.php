<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {

        // Pegando arquivos json
        $url = storage_path('app/public/json/prices.json');
        $prices = json_decode(file_get_contents($url), true);

        $url_plans = storage_path('app/public/json/plans.json');
        $plans = json_decode(file_get_contents($url_plans), true);

        
        return view('welcome', [
            'prices' => $prices,
            'plans' => $plans
        ]);
    }

    public function plano_escolhido(Request $request, $codigo) {

        // Pegando arquivos json
        $url_plans = storage_path('app/public/json/plans.json');
        $plans = json_decode(file_get_contents($url_plans), true);

        $url_prices = storage_path('app/public/json/prices.json');
        $prices = json_decode(file_get_contents($url_prices), true);

        if ($codigo != null) {

            // Looping para pegar plano pertencente ao código vindo por parâmetro
            foreach($plans as $plan){

                if ($plan['codigo'] == $codigo){
                    
                    $plano_escolhido = $plan;

                    foreach($prices as $price){
                
                        if($price['codigo'] == $codigo) {

                            $dados_plano_escolhido = $price;

                            // Sessão para armazenar plano escolhido e inserir em json
                            $request->session()->put('plano', $plano_escolhido);

                            return view('/cadastro', [
                                'plano_escolhido' => $plano_escolhido,
                                'dados_plano_escolhido' => $dados_plano_escolhido
                            ]);

                        }
                    }
                }
            }
            
        } else {
            return view('welcome')->with('erro', 'Plano inválido');
        }
    }

    public function tratar_dados(Request $request) {

        // Convertendo data para idade        
        $idade = [];
        foreach($request->dataNascimento as $data) {
      
            // data de hoje
            $hoje = new \DateTime();
            $parametro_data = new \DateTime($data);
            
            // Calcular ano (Se o ano de atual for igual ao ano da data vinda por parametro)
            if($hoje->format('Y') == $parametro_data->format('Y')) {

                $idade[] = 0;

            } 
                        
            else if ($hoje->format('Y') > $parametro_data->format('Y')) {
                
                // Verificar mês
                if ($hoje->format('m') > $parametro_data->format('m')) {

                    $idade[] = $hoje->format('Y') - $parametro_data->format('Y');
                
                // Se o mês for igual, verificar dia
                } else if ($hoje->format('m') < $parametro_data->format('m')) {
                    
                    $idade[] = $hoje->format('Y') - $parametro_data->format('Y') - 1;

                } else if ($hoje->format('m') == $parametro_data->format('m')) {

                    if ($hoje->format('d') > $parametro_data->format('d')) {
                    
                        $idade[] = $hoje->format('Y') - $parametro_data->format('Y');
                    
                    } else {

                        $idade[] = $hoje->format('Y') - $parametro_data->format('Y') - 1;
                    
                    }
                    
                }
                
                
            }
            
            
        }

        // Sessões para inserir dados em beneficiarios.json
        $request->session()->put('nomes', $request->nome);
        $request->session()->put('idades', $idade);
        $request->session()->put('quantidade', $request->quantidade);

        // Se todas sessões não estiverem vazias
        if (session()->get('nomes') != null && session()->get('idades') != null && session()->get('quantidade') != null && session()->get('plano') != null) {

            // Criando array com dados pra inserir em beneficiarios.json
            $dados['codigo'] = session()->get('plano')['codigo'];
            $dados['plano'] = session()->get('plano')['nome'];
            $dados['quantidade'] = session()->get('quantidade');
            $dados['nomes'] = session()->get('nomes');
            $dados['idades'] = session()->get('idades');

            // Escrever arquivo beneficiarios.json
            $url = storage_path('app/public/json/beneficiarios.json');
            $abrir_arquivo = fopen($url, 'w');
            fwrite($abrir_arquivo, json_encode($dados));
            fclose($abrir_arquivo);

            // Retornar resposta para ajax e fazer o redirecionamento
            echo 'true';

        } else {

            // Retornar resposta para ajax e exibir erro
            echo 'false';
        
        }

    }

    public function orcamento() {

        // Selecionando arquivos json
        $url_prices = storage_path('app/public/json/prices.json');
        $prices = json_decode(file_get_contents($url_prices), true);

        $url_beneficiarios = storage_path('app/public/json/beneficiarios.json');
        $beneficiarios = json_decode(file_get_contents($url_beneficiarios), true);

        // Selecionando preços de plano escolhido
        $plano = [];
        foreach($prices as $price) {
            /* 
                Caso o plano tenha mais de 1 variedade de preço (Como o plano 1 e 6)
                de acordo com a quantidade de pessoas participante
                adicione no final do array
            */ 
            if ($price['codigo'] == $beneficiarios['codigo']) {
                array_push($plano, $price);
            }
        
        }
        
        // Se existir mais de uma variedade de preços dentro do array plano
        if(count($plano) > 1) {
            
            $valores = [];    
            
            foreach($plano as $plan) {

                // Se a quantidade de participantes do plano for igual ou maior que o minimo aceitavel
                if ($beneficiarios['quantidade'] >= $plan['minimo_vidas']) {

                    $valores = [];    
                    // Pegue cada idade e de o preço de acordo com o plano
                    foreach($beneficiarios['idades'] as $idade) {
                                    
                        if ($idade <= 18) {
                            array_push($valores, $plan['faixa1']);
                        } else if ($idade <= 40) {
                            array_push($valores, $plan['faixa2']);
                        } else if ($idade > 40) {
                            array_push($valores, $plan['faixa3']);
                        }
                    }
            
                }               
            }

           

        } else {

            for($contador = 0; $contador < count($plano); $contador ++) {

                if ($beneficiarios['quantidade'] >= $plano[$contador]['minimo_vidas']) {

                    $valores = [];    
                    // Pegue cada idade e de o preço de acordo com o plano
                    foreach($beneficiarios['idades'] as $idade) {
                                    
                        if ($idade <= 18) {
                            array_push($valores, $plano[$contador]['faixa1']);
                        } else if ($idade <= 40) {
                            array_push($valores, $plano[$contador]['faixa2']);
                        } else if ($idade > 40) {
                            array_push($valores, $plano[$contador]['faixa3']);
                        }
                    }
                }        
            }
        }

        // Array para orçamento
        $orcamento['plano'] = $beneficiarios['plano'];
        $orcamento['quantidade'] = $beneficiarios['quantidade'];
        $orcamento['nomes'] = $beneficiarios['nomes'];
        $orcamento['idades'] = $beneficiarios['idades'];
        $orcamento['individual'] = $valores;
        $orcamento['total'] = array_sum($valores);

        // Escrever proposta no arquivo json
        $url = storage_path('app/public/json/proposta.json');
        $abrir_arquivo = fopen($url, 'w');
        fwrite($abrir_arquivo, json_encode($orcamento));
        fclose($abrir_arquivo);

        return view('proposta', [
            'orcamento' => $orcamento
        ]);
    }

}