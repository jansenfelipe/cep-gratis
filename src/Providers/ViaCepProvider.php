<?php

namespace JansenFelipe\CepGratis\Providers;

use JansenFelipe\CepGratis\Contracts\ProviderContract;

class ViaCepProvider extends ProviderContract
{
    /**
     * @return resource
     */
    public function getCurl()
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => 'https://viacep.com.br/ws/'.$this->cep.'/json/',
            CURLOPT_RETURNTRANSFER => true,
        ]);

        return $this->curl;
    }

    /**
     * @return Endereco
     */
    public function parseEndereco($data)
    {
        $endereco = $data;
    }
}