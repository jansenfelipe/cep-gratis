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
        $crawler = $client->request('POST', 'http://www.buscacep.correios.com.br/servicos/dnec/consultaLogradouroAction.do', array(
            'relaxation' => Utils::unmask($cep),
            'Metodo' => 'listaLogradouro',
            'TipoConsulta' => 'relaxation',
            'StartRow' => '1',
            'EndRow' => '10'
        ));

        $tr = $crawler->filter(".ctrlcontent > div:nth-child(7) > table:nth-child(1) > tr:nth-child(1)");

        $retorno = array(
            'logradouro' => $tr->filter("td:nth-child(1)")->html(),
            'bairro' => $tr->filter("td:nth-child(2)")->html(),
            'cidade' => $tr->filter("td:nth-child(3)")->html(),
            'uf' => $tr->filter("td:nth-child(4)")->html(),
            'cep' => Utils::unmask($tr->filter("td:nth-child(5)")->html())
        );

        $aux = explode(" - ", $retorno['logradouro']);
        $retorno['logradouro'] = (count($aux) == 2) ? $aux[0] : $retorno['logradouro'];

        return array_map('htmlentities', array_map('trim', $retorno));
    }

}
