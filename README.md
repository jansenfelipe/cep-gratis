# CEP Grátis
[![Travis](https://travis-ci.org/jansenfelipe/cep-gratis.svg?branch=2.0)](https://travis-ci.org/jansenfelipe/cep-gratis)
[![Latest Stable Version](https://poser.pugx.org/jansenfelipe/cep-gratis/v/stable.svg)](https://packagist.org/packages/jansenfelipe/cep-gratis) 
[![Total Downloads](https://poser.pugx.org/jansenfelipe/cep-gratis/downloads.svg)](https://packagist.org/packages/jansenfelipe/cep-gratis) 
[![Latest Unstable Version](https://poser.pugx.org/jansenfelipe/cep-gratis/v/unstable.svg)](https://packagist.org/packages/jansenfelipe/cep-gratis)
[![MIT license](https://img.shields.io/dub/l/vibe-d.svg)](http://opensource.org/licenses/MIT)

Com esse pacote você poderá realizar consultas de CEP no site dos correios gratuitamente.

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
$endereco = JansenFelipe\CepGratis\CepGratis::consultar('31030080'); 
```

### License

The MIT License (MIT)
