<?php

namespace JansenFelipe\CepGratis\Providers;

use JansenFelipe\CepGratis\Address;
use JansenFelipe\CepGratis\Contracts\HttpClientContract;
use JansenFelipe\CepGratis\Contracts\ProviderContract;
use Symfony\Component\DomCrawler\Crawler;

class CorreiosProvider implements ProviderContract
{
    /**
     * @return Address
     */
    public function getAddress($cep, HttpClientContract $client)
    {
        $response = $client->post('http://www.buscacep.correios.com.br/sistemas/buscacep/detalhaCEP.cfm', [
            'CEP' => $cep,
        ]);

        if (!is_null($response)) {
            $crawler = new Crawler($response);

            $message = $crawler->filter('div.ctrlcontent p')->html();

            if ($message == 'DADOS ENCONTRADOS COM SUCESSO.') {
                $tr = $crawler->filter('table.tmptabela');

                $params['zipcode'] = $cep;
                $params['street'] = $tr->filter('tr:nth-child(1) td:nth-child(2)')->html();
                $params['neighborhood'] = $tr->filter('tr:nth-child(2) td:nth-child(2)')->html();

                $aux = explode('/', $tr->filter('tr:nth-child(3) td:nth-child(2)')->html());
                $params['city'] = $aux[0];
                $params['state'] = $aux[1];

                $aux = explode(' - ', $params['street']);
                $params['street'] = (count($aux) == 2) ? $aux[0] : $params['street'];

                return Address::create(array_map(function ($item) {
                    return urldecode(str_replace('%C2%A0', '', urlencode($item)));
                }, $params));
            }
        }
    }
}
