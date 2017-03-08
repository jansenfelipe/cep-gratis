<?php

namespace JansenFelipe\CepGratis;

use Exception;
use PHPUnit_Framework_TestCase;

class CepGratisTest extends PHPUnit_Framework_TestCase {

    public function testConsulta()
    {
        $cepGratis = new CepGratis();
        $cepGratis->consulta('99999999');

        $endereco = $cepGratis->consulta('99999999');

        $this->assertEquals('Rua Alabastro', $endereco['logradouro']);
        $this->assertEquals('Sagrada Fam&iacute;lia', $endereco['bairro']);
        $this->assertEquals('Belo Horizonte', $endereco['cidade']);
        $this->assertEquals('31030-080', $endereco['cep']);
        $this->assertEquals('MG', $endereco['uf']);
        
        
        $endereco = CepGratis::consulta('48110000');
        
        $this->assertEquals('', $endereco['logradouro']);
        $this->assertEquals('', $endereco['bairro']);
        $this->assertEquals('Catu', $endereco['cidade']);
        $this->assertEquals('48110-000', $endereco['cep']);
        $this->assertEquals('BA', $endereco['uf']);
    }

    public function testConsultaCepInexistente()
    {
        try{
            CepGratis::consulta('12345678');
        }catch (Exception $e){
            $this->assertEquals('O cep informado não existe', $e->getMessage());
        }
    }

}
