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
				$trs = $crawler->filter('table.tmptabela tr');
				
				$params['zipcode'] = $cep;
				
				foreach ($trs as $tr) {
				 $dados = explode(':', $tr->nodeValue);
				 
				 switch(trim($dados[0])) {
				  case 'Logradouro':
				   $params['street'] = trim($dados[1]);
				   $aux = explode(' - ', $params['street']);
				   $params['street'] = (count($aux) == 2) ? trim($aux[0]) : trim($params['street']);
				   break;
				  case 'Bairro':
				   $params['neighborhood'] = trim($dados[1]);
				   break;
				  case 'Localidade/UF':
				   $aux = explode('/', trim($dados[1]));
				   $params['city'] = trim($aux[0]);
				   $params['state'] = trim($aux[1]);
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
