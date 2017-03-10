<?php
namespace JansenFelipe\CepGratis;

use Exception;
use InvalidArgumentException;
use Goutte\Client;
use JansenFelipe\Utils\Utils as Utils;

class CepGratis {
    /**
     * Metodo para realizar a consulta
     *
     * @throws  Exception
     * @param   string $cep CEP
     * @return  array  Endereço
     */
    public static function consulta($cep) {

        if (strlen($cep) < 8) {
            throw new InvalidArgumentException('O cep informado não parece ser válido');
        }

        $client		= new Client();
        $crawler 	= $client->request('POST', 'http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm', [
            'relaxation'  => Utils::unmask($cep),
            'tipoCEP'     => 'ALL',
            'semelhante'  => 'N'
        ]);

        // Realiza a filtragem para que somente a linha que contenha os
        // dados que queremos possa ser localizada
        $tr = $crawler->filter(".tmptabela > tr:nth-child(2)");

        // Se a tabela nao existir, nao foi encontrado nenhum resultado
        if(!$tr->count()) {
            throw new CepNotFoundException('O cep informado não existe');
        }

        // Recebe o endereço obtido através da consulta
        $endereco = [
            'logradouro'	=> $tr->filter("td:nth-child(1)")->html(),
            'bairro'		=> $tr->filter('td:nth-child(2)')->html(),
            'cidade'		=> $tr->filter('td:nth-child(3)')->html(),
            'cep'			=> $tr->filter('td:nth-child(4)')->html()
        ];

        // Remove um dos logradouros, caso a consulta traga mais de um,
        // como por exemplo: Rua América - Rua G
        $aux = explode(" - ", $endereco['logradouro']);
        $endereco['logradouro'] = (count($aux) == 2) ? $aux[0] : $endereco['logradouro'];

        // Separa a cidade do Estado. Anteriormente estes campos vinham em TD's separadas
        // agora, vêm juntas, separadas por uma barra
        $separado = explode('/', $endereco['cidade']);
        $endereco['cidade'] = $separado[0];
        $endereco['uf']     = $separado[1];

        return str_replace('&nbsp;', '', array_map('htmlentities', array_map('trim', $endereco)));
    }
}
