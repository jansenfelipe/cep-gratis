<?php

namespace JansenFelipe\CepGratis\Providers;

use JansenFelipe\CepGratis\Contracts\ProviderContract;

class CorreiosProvider extends ProviderContract
{
    /**
     * @return resource
     */
    public function getCurl()
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => 'http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaCepEndereco.cfm',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query(['relaxation' => $this->cep, 'tipoCEP' => 'ALL', 'semelhante'  => 'N'])
        ]);

        return $this->curl;
    }

    /**
     * @return Endereco
     */
    public function parseEndereco($data)
    {
        // TODO: Implement getEndereco() method.
    }
}