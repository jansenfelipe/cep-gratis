<?php

namespace JansenFelipe\CepGratis\Tests\Providers;

use JansenFelipe\CepGratis\Contracts\HttpClientContract;
use JansenFelipe\CepGratis\Providers\CorreiosProvider;
use JansenFelipe\CepGratis\Tests\Util;
use PHPUnit_Framework_TestCase;

class CorreiosProviderTest extends PHPUnit_Framework_TestCase
{
    public function testGetSuccessAddress()
    {
        $httpClientStub = $this->getMockBuilder(HttpClientContract::class)->getMock();

        $httpClientStub->method('post')->willReturn(file_get_contents(Util::base_path('resources/correios.success.html')));

        $correiosProvider = new CorreiosProvider();

        $address = $correiosProvider->getAddress('31030080', $httpClientStub);

        $this->assertEquals('31030080', $address->zipcode);
        $this->assertEquals('Rua Alabastro', $address->street);
        $this->assertEquals('Sagrada Família', $address->neighborhood);
        $this->assertEquals('Belo Horizonte', $address->city);
        $this->assertEquals('MG', $address->state);
    }

    public function testGetErrorAddress()
    {
        $httpClientStub = $this->getMockBuilder(HttpClientContract::class)->getMock();

        $httpClientStub->method('post')->willReturn(file_get_contents(Util::base_path('resources/correios.error.html')));

        $correiosProvider = new CorreiosProvider();

        $address = $correiosProvider->getAddress('31030080', $httpClientStub);

        $this->assertEquals($address, null);
    }
}
