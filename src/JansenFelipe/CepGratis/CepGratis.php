<?php

namespace JansenFelipe\CepGratis;

class CepGratis {

    /**
     * Metodo para realizar a consulta
     *
     * @param  string $cep CEP
     * @return array  Endereço
     */
    public function consulta($cep) {
        $html = $this->curl('http://m.correios.com.br/movel/buscaCepConfirma.do', array(
            'cepEntrada' => $cep,
            'tipoCep' => '',
            'cepTemp' => '',
            'metodo' => 'buscarCep'
        ));

        
        require_once 'phpQuery-onefile';
        \phpQuery::newDocumentHTML($html, $charset = 'utf-8');

        $resposta = array(
            'logradouro' => trim(\phpQuery::pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
            'bairro' => unaccents(trim(\phpQuery::pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html())),
            'cep' => trim(\phpQuery::pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
        );

        $aux = explode(" - ", $resposta['logradouro']);
        if (count($aux) == 2)
            $resposta['logradouro'] = $aux[0];

        $cidadeUF = explode("/", trim(\phpQuery::pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()));

        $resposta['cidade'] = unaccents(utf8_encode(trim($cidadeUF[0])));
        $resposta['uf'] = trim($cidadeUF[1]);

        return $resposta;
    }

    /**
     * Metodo para enviar a requisição
     * @return String HTML
     */
    private function curl($url, $post = array(), $get = array()) {
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        return curl_exec($ch);
    }

}
