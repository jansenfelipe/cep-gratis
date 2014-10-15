<?php

namespace JansenFelipe\CepGratis;

use PHPUnit_Framework_TestCase;

class CepGratisTest extends PHPUnit_Framework_TestCase {

    public function testConsulta() {

        $endereco1 = CepGratis::consulta('31030080');
        $this->assertEquals(true, isset($endereco1['logradouro']));
                
        $endereco2 = CepGratis::consulta('30.240-440');
        $this->assertEquals(true, isset($endereco2['logradouro']));
    }

}
