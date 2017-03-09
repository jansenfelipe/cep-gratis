<?php

namespace JansenFelipe\CepGratis\Providers;

use JansenFelipe\CepGratis\Address;
use JansenFelipe\CepGratis\Contracts\HttpClientContract;
use JansenFelipe\CepGratis\Contracts\ProviderContract;

class ViaCepProvider implements ProviderContract
{
    /**
     * @return Address|null
     */
    public function getAddress($cep, HttpClientContract $client)
    {
        $response = $client->get('https://viacep.com.br/ws/'.$cep.'/json/');

        if (!is_null($response)) {
            $data = json_decode($response, true);

            return Address::create([
                'zipcode'      => $cep,
                'street'       => $data['logradouro'],
                'neighborhood' => $data['bairro'],
                'city'         => $data['localidade'],
                'state'        => $data['uf'],
            ]);
        }
    }
}
