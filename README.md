# CEP Grátis
[![Travis](https://api.travis-ci.org/jansenfelipe/cep-gratis.svg?branch=4.0)](https://travis-ci.org/jansenfelipe/cep-gratis)
[![StyleCI](https://styleci.io/repos/24848930/shield?branch=4.0)](https://styleci.io/repos/24848930?branch=4.0)
[![Latest Stable Version](https://poser.pugx.org/jansenfelipe/cep-gratis/v/stable.svg)](https://packagist.org/packages/jansenfelipe/cep-gratis) 
[![Total Downloads](https://poser.pugx.org/jansenfelipe/cep-gratis/downloads.svg)](https://packagist.org/packages/jansenfelipe/cep-gratis) 
[![MIT license](https://poser.pugx.org/jansenfelipe/nfephp-serialize/license.svg)](http://opensource.org/licenses/MIT)

Com esse pacote você poderá realizar consultas de CEP gratuitamente.

Para evitar problemas com indisponibilidade de serviços, a consulta é realizada paralelamente em providers diferentes:

* [Website dos correios](http://www.buscacep.correios.com.br/sistemas/buscacep/)
* [API Viacep](https://viacep.com.br/)

A library irá retornar para você a resposta mais rápida, aumentando assim a performance da consulta.

### Changelog

* 4.0.2 - 27/03/2018 Consulta direto na tela de detalhe dos Correios. Obrigado [@adrianogl](https://github.com/adrianogl)
* 4.0.0 - 11/03/2017 Consulta em múltiplos providers, interface HttpClient
* 3.0.1 - 10/03/2016 Tratar cep inexistente. Obrigado [@nunesbeto](https://github.com/nunesbeto)
* 3.0.0 - 08/03/2016 Up version fabpot/goutte
* 2.0.4 - 05/03/2016 Ajuste pois o site dos Correios sofreu alteração. Obrigado [@devLopez](https://github.com/devLopez)


### Como utilizar

Adicione a library

```shell
$ composer require jansenfelipe/cep-gratis
```
    
Adicione o autoload.php do composer no seu arquivo PHP.

```php
require_once 'vendor/autoload.php';  
```

Agora basta chamar o método `CepGratis::search($cep)`

```php
use JansenFelipe\CepGratis\CepGratis;

$address = CepGratis::search('31030080'); 
```

### Gostou? Conheça também

* [CnpjGratis](https://github.com/jansenfelipe/cnpj-gratis)
* [CpfGratis](https://github.com/jansenfelipe/cpf-gratis)
* [CidadesGratis](https://github.com/jansenfelipe/cidades-gratis)
* [NFePHPSerialize](https://github.com/jansenfelipe/nfephp-serialize)

### License

The MIT License (MIT)
