<?php

namespace JansenFelipe\CepGratis\Providers;

use JansenFelipe\CepGratis\Address;
use JansenFelipe\CepGratis\Contracts\HttpClientContract;
use JansenFelipe\CepGratis\Contracts\ProviderContract;

class CorreiosProvider implements ProviderContract
{
    /**
     * @return Address
     */
    public function getAddress($cep, HttpClientContract $client)
    {
        $response = $client->post('http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm',[
            'relaxation' => $cep,
            'tipoCEP' => 'ALL',
            'semelhante'  => 'N'
        ]);

        if(!is_null($response))
        {
            return Address::create([
                'cep' => $cep
            ]);
        }
    }
}