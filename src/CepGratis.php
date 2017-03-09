<?php
namespace JansenFelipe\CepGratis;

use Exception;
use JansenFelipe\CepGratis\Contracts\HttpClientContract;
use JansenFelipe\CepGratis\Contracts\ProviderContract;
use JansenFelipe\CepGratis\Providers\CorreiosProvider;
use JansenFelipe\CepGratis\Providers\ViaCepProvider;
use JansenFelipe\CepGratis\Clients\CurlHttpClient;

class CepGratis
{
    /**
     * @var HttpClientContract
     */
    private $client;

    /**
     * @var ProviderContract[]
     */
    private $providers = [];

    /**
     * CepGratis constructor.
     */
    public function __construct()
    {
        $this->client = new CurlHttpClient();
    }

    /**
     * Pesquisa CEP
     *
     * @param   string $cep CEP
     * @return  Address
     */
    public static function search($cep)
    {
        $cepGratis = new CepGratis();
        $cepGratis->addProvider(new ViaCepProvider());
        $cepGratis->addProvider(new CorreiosProvider());

        $address = $cepGratis->resolve($cep);

        return $address;
    }

    /**
     * Realiza consulta de CEP
     *
     * @param   string $cep CEP
     * @param   ProviderContract $provider
     * @return  Address
     */
    public function resolve($cep)
    {
        if (strlen($cep) < 8)
            throw new Exception('O cep informado não parece ser válido');

        if (count($this->providers) == 0)
            throw new Exception('Nenhum provider foi informado');

        /*
         * Execute
         */
        do {

            foreach ($this->providers as $provider)
                $address = $provider->getAddress($cep, $this->client);

        } while (is_null($address));

        return $address;
    }

    /**
     * Informa um client http
     *
     * @param HttpClientContract $client
     */
    public function setClient(HttpClientContract $client)
    {
        $this->client = $client;
    }

    /**
     * Adiciona providers para consulta de CEP
     *
     * @param HttpClientContract $client
     */
    public function addProvider(ProviderContract $provider)
    {
        $this->providers[] = $provider;
    }
}
