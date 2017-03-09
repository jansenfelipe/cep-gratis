<?php

namespace JansenFelipe\CepGratis;

use Exception;
use PHPUnit_Framework_TestCase;

class CepGratisTest extends PHPUnit_Framework_TestCase {

    public function testConsulta()
    {
        $address = CepGratis::search('31030080');

        $this->assertEquals('Rua Alabastro', $address->street);
        $this->assertEquals('Sagrada Família', $address->neighborhood);
        $this->assertEquals('Belo Horizonte', $address->city);
        $this->assertEquals('31030080', $address->zipcode);
        $this->assertEquals('MG', $address->state);
    }
}
