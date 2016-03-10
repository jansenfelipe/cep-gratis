# CEP Grátis
[![Travis](https://travis-ci.org/jansenfelipe/cep-gratis.svg?branch=2.0)](https://travis-ci.org/jansenfelipe/cep-gratis)
[![Latest Stable Version](https://poser.pugx.org/jansenfelipe/cep-gratis/v/stable.svg)](https://packagist.org/packages/jansenfelipe/cep-gratis) 
[![Total Downloads](https://poser.pugx.org/jansenfelipe/cep-gratis/downloads.svg)](https://packagist.org/packages/jansenfelipe/cep-gratis) 
[![Latest Unstable Version](https://poser.pugx.org/jansenfelipe/cep-gratis/v/unstable.svg)](https://packagist.org/packages/jansenfelipe/cep-gratis)
[![MIT license](https://poser.pugx.org/jansenfelipe/nfephp-serialize/license.svg)](http://opensource.org/licenses/MIT)

Com esse pacote você poderá realizar consultas de CEP no site dos correios gratuitamente.

### Changelog

* 3.0.1 - 10/03/2016 Tratar cep inexistente. Obrigado [@nunesbeto](https://github.com/nunesbeto)
* 3.0.0 - 08/03/2016 Up version fabpot/goutte
* 2.0.4 - 05/03/2016 Ajuste pois o site dos Correios sofreu alteração. Obrigado [@devLopez](https://github.com/devLopez)


### Como utilizar

Adicione a library

```sh
$ composer require jansenfelipe/cep-gratis
```
    
Adicione o autoload.php do composer no seu arquivo PHP.

```php
require_once 'vendor/autoload.php';  
```

Agora basta chamar o metodo consultar($cep)

```php
$endereco = JansenFelipe\CepGratis\CepGratis::consulta('31030080'); 
```

### Gostou? Conheça também

* [CnpjGratis](https://github.com/jansenfelipe/cnpj-gratis)
* [CpfGratis](https://github.com/jansenfelipe/cpf-gratis)
* [CidadesGratis](https://github.com/jansenfelipe/cidades-gratis)
* [NFePHPSerialize](https://github.com/jansenfelipe/nfephp-serialize)

### License

The MIT License (MIT)
