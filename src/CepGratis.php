<?php
namespace JansenFelipe\CepGratis;
use Exception;
use Goutte\Client;
use JansenFelipe\Utils\Utils as Utils;
class CepGratis {
    /**
     * Metodo para realizar a consulta no Correios Mobile
     *
     * @throws  Exception
     * @param   string $cep CEP
     * @return  array  Endereço
     */
    public static function consulta($cep) {
        if (strlen($cep) < 8)
            throw new Exception('O cep informado não parece ser válido');
        $client		= new Client();
        $crawler 	= $client->request('POST', 'http://m.correios.com.br/movel/buscaCepConfirma.do', [
            'cepEntrada'  => Utils::unmask($cep),
            'tipoCep'=>'All',
			'metodo'=>'buscarCep'
        ]);
        // Verifica se a <div class="erro"> contem no resultado
        // O @ para caso de um erro no filter
        @ $erro = $crawler->filter('.erro');
        // Se o resultado nao existir, nao foi encontrado nenhum resultado
        if($erro->count())
            throw new Exception('O cep informado não existe');
        // Recebe o endereço obtido através da consulta
        $endereco = [
            'logradouro'	=> $crawler->filter(
            	'.resposta:contains("Logradouro: ") + .respostadestaque')->html(),
            'bairro'		=> $crawler->filter(
            	'.resposta:contains("Bairro: ") + .respostadestaque')->html(),
            'cidade'		=> $crawler->filter(
            	'.resposta:contains("Localidade / UF: ") + .respostadestaque')->html(),
            'cep'			=> $crawler->filter(
            	'.resposta:contains("CEP: ") + .respostadestaque')->html()
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
