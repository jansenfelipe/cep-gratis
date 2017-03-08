<?php
namespace JansenFelipe\CepGratis;

use Exception;
use JansenFelipe\CepGratis\Contracts\ProviderContract;
use JansenFelipe\CepGratis\Providers\CorreiosProvider;
use JansenFelipe\CepGratis\Providers\ViaCepProvider;

class CepGratis
{
    /**
     * @var ProviderContract[]
     */
    private $providers = [];

    /**
     * @var resources[]
     */
    private $curls = [];

    /**
     * @var Endereco
     */
    private $endereco = null;

    /**
     * Realiza consulta de CEP
     *
     * @param   string $cep CEP
     * @return  Endereco
     */
    public function consulta($cep)
    {
        if (strlen($cep) < 8)
            throw new Exception('O cep informado não parece ser válido');

        /*
         * Instance providers
         */
        $this->providers = [
            //new CorreiosProvider($cep),
            new ViaCepProvider($cep)
        ];

        /*
         * Multi cURL
         */
        $multi = curl_multi_init();

        foreach ($this->providers as $key => $provider)
        {
            $this->curls[$key] = $provider->getCurl();

            curl_multi_add_handle($multi, $this->curls[$key]);
        }

        /*
         * Execute
         */
        do {

            curl_multi_exec($multi, $qtd);
            curl_multi_select($multi);

            if($qtd < count($this->providers) && $this->isFinalized())
                break;

        } while ($qtd > 0);

        return $this->endereco;
    }

    /**
     * Verifica sucesso de alguma resposta
     *
     * @return  boolean
     */
    private function isFinalized()
    {
        foreach ($this->providers as $key => $provider)
        {
            if(curl_getinfo($this->curls[$key], CURLINFO_HTTP_CODE) != 0)
            {
                $content = curl_multi_getcontent($this->curls[$key]);

                $this->endereco = $provider->parseEndereco($content);
            }
        }

        return !is_null($this->endereco);
    }
}
