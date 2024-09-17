<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function do_get($url) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true);
    }

    protected function validaCPF($cpf) {

        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;

    }

    // Validar numero de CNPJ
    protected function validaCNPJ($cnpj) {
        // Verificar se foi informado
        if(empty($cnpj))
            return false;
        // Remover caracteres especias
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        // Verifica se o numero de digitos informados
        if (strlen($cnpj) != 14)
            return false;
            // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
            for ($i = 0, $n = 0; $i < 12; $n += $cnpj[$i] * $b[++$i]);
            if ($cnpj[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
                return false;
            }
            for ($i = 0, $n = 0; $i <= 12; $n += $cnpj[$i] * $b[$i++]);
            if ($cnpj[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
                return false;
            }
        return true;
    }

    protected function validaCelular($telefone){
        $telefone= trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));

        $regexCel = '/[0-9]{2}[6789][0-9]{4}[0-9]{4}/';
        if (preg_match($regexCel, $telefone)) {
            return true;
        }else{
            return false;
        }
    }
    protected function validaTelefone($telefone){
        $telefone= trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));

        $regexCel = '/[0-9]{2}[0-9]{4}[0-9]{4}/';
        if (preg_match($regexCel, $telefone)) {
            return true;
        }else{
            return false;
        }
    }

}
