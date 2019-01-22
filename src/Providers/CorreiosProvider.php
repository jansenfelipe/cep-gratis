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
                $params['street'] = '';
                $params['neighborhood'] = '';
                $params['city'] = '';
                $params['state'] = '';

                for ($i = 1; $i <= 3; $i++) {
                    if ($tr->filter('tr:nth-child('.$i.') th:nth-child(1)')->count() <= 0) {
                        break;
                    }

                    $index = trim($tr->filter('tr:nth-child('.$i.') th:nth-child(1)')->text(), ':');
                    $value = $tr->filter('tr:nth-child('.$i.') td:nth-child(2)')->text();
                    switch ($index) {
                        case 'Logradouro':
                            $aux = explode(' - ', $value);
                            $params['street'] = (count($aux) == 2) ? $aux[0] : $value;
                            break;
                        case 'Bairro':
                            $params['neighborhood'] = $value;
                            break;
                        case 'Localidade/UF':
                            $aux = explode('/', $value);
                            $params['city'] = $aux[0];
                            $params['state'] = $aux[1];
                            break;
                    }
                }

                return Address::create(array_map(function ($item) {
                    return urldecode(str_replace('%C2%A0', '', urlencode($item)));
                }, $params));
            }
        }
    }
}
