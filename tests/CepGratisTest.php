<?php

namespace JansenFelipe\CepGratis;

use PHPUnit_Framework_TestCase;

class CepGratisTest extends PHPUnit_Framework_TestCase {

    public function testConsulta() {

        $endereco = CepGratis::consulta('31030080');

        $this->assertEquals('Rua Alabastro', $endereco['logradouro']);
        $this->assertEquals('Sagrada Fam&iacute;lia', $endereco['bairro']);
        $this->assertEquals('Belo Horizonte', $endereco['cidade']);
        $this->assertEquals('31030080', $endereco['cep']);
        $this->assertEquals('MG', $endereco['uf']);
        
        
        $endereco = CepGratis::consulta('48110000');
        
        $this->assertEquals('', $endereco['logradouro']);
        $this->assertEquals('', $endereco['bairro']);
        $this->assertEquals('Catu', $endereco['cidade']);
        $this->assertEquals('48110000', $endereco['cep']);
        $this->assertEquals('BA', $endereco['uf']);
        
    }

}
