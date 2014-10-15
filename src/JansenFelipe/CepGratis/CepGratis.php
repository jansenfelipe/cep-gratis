<?php

namespace JansenFelipe\CepGratis;

use \JansenFelipe\Utils\Utils as Utils;

class CepGratis {

    /**
     * Metodo para realizar a consulta
     *
     * @param  string $cep CEP
     * @return array  Endereço
     */
    public static function consulta($cep) {

        $html = self::curl('http://m.correios.com.br/movel/buscaCepConfirma.do', array(
            'cepEntrada' => Utils::unmask($cep),
            'tipoCep' => '',
            'cepTemp' => '',
            'metodo' => 'buscarCep'
        ));


        require_once __DIR__ . DIRECTORY_SEPARATOR . 'phpQuery-onefile.php';
        \phpQuery::newDocumentHTML($html, $charset = 'utf-8');

        $resposta = array(
            'logradouro' => trim(\phpQuery::pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
            'bairro' => trim(\phpQuery::pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
            'cep' => trim(\phpQuery::pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
        );
        $aux = explode(" - ", $resposta['logradouro']);
        if (count($aux) == 2)
            $resposta['logradouro'] = $aux[0];

        $cidadeUF = explode("/", trim(\phpQuery::pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()));

        $resposta['cidade'] = trim($cidadeUF[0]);
        $resposta['uf'] = trim($cidadeUF[1]);

        return array_map('html_entity_decode', array_map('htmlentities', $resposta));
    }

    /**
     * Metodo para enviar a requisição
     * @return String HTML
     */
    private static function curl($url, $post = array(), $get = array()) {
        $url = explode('?', $url, 2);
        if (count($url) === 2) {
            $temp_get = array();
            parse_str($url[1], $temp_get);
            $get = array_merge($get, $temp_get);
        }

        $ch = curl_init($url[0] . "?" . http_build_query($get));

        if (count($post) > 0) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        return curl_exec($ch);
    }

}
