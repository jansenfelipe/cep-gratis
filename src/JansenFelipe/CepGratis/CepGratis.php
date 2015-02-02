<?php

namespace JansenFelipe\CepGratis;

use Exception;
use Goutte\Client;
use JansenFelipe\Utils\Utils as Utils;

class CepGratis {

    /**
     * Metodo para realizar a consulta
     *
     * @throws Exception
     * @param  string $cep CEP
     * @return array  Endereço
     */
    public static function consulta($cep) {

        if (strlen($cep) < 8)
            throw new Exception('O cep informado não parece ser válido');

        $client = new Client();
        $crawler = $client->request('POST', 'http://m.correios.com.br/movel/buscaCepConfirma.do', array(
            'cepEntrada' => Utils::unmask($cep),
            'tipoCep' => '',
            'cepTemp' => '',
            'metodo' => 'buscarCep'
        ));

        $retorno = array('logradouro' => null, 'bairro' => null, 'cidade' => null, 'cep' => null, 'uf' => null);

        $respostas = $crawler->filter(".caixacampobranco > span.resposta");
        $respostaDestaques = $crawler->filter(".caixacampobranco > span.respostadestaque");

        for ($i = 0; $i < $respostas->count(); $i++) {
            switch ($respostas->eq($i)->html()) {

                case 'Logradouro: ':
                    $aux = explode(" - ", $respostaDestaques->eq($i)->html());
                    $retorno['logradouro'] = (count($aux) == 2) ? $aux[0] : $respostaDestaques->eq($i)->html();
                    break;

                case 'Bairro: ':
                    $retorno['bairro'] = $respostaDestaques->eq($i)->html();
                    break;

                case 'Localidade / UF: ':
                    $explode = explode('/', $respostaDestaques->eq($i)->html());
                    $retorno['cidade'] = $explode[0];
                    $retorno['uf'] = $explode[1];
                    break;

                case 'CEP: ':
                    $retorno['cep'] = $respostaDestaques->eq($i)->html();
                    break;
            }
        }

        return array_map('htmlentities', array_map('trim', $retorno));
    }

}
