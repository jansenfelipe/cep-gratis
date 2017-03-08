<?php

namespace JansenFelipe\CepGratis\Contracts;

abstract class ProviderContract
{
    protected $curl;

    protected $cep;

    public function __construct($cep)
    {
        $this->curl = curl_init();
        $this->cep = $cep;
    }

    /**
     * @return Endereco
     */
    abstract public function parseEndereco($data);

    /**
     * @return resource
     */
    abstract public function getCurl();
}