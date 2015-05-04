# CEP Grátis
[![Travis](https://travis-ci.org/jansenfelipe/cep-gratis.svg?branch=2.0)](https://travis-ci.org/jansenfelipe/cep-gratis)
[![Latest Stable Version](http://img.shields.io/packagist/v/jansenfelipe/cep-gratis.svg?style=flat)](https://packagist.org/packages/jansenfelipe/cep-gratis)
[![Total Downloads](http://img.shields.io/packagist/dt/jansenfelipe/cep-gratis.svg?style=flat)](https://packagist.org/packages/jansenfelipe/cep-gratis)
[![License](http://img.shields.io/packagist/l/jansenfelipe/cep-gratis.svg?style=flat)](https://packagist.org/packages/jansenfelipe/cep-gratis)

Com esse pacote você poderá realizar consultas de CEP no site dos correios gratuitamente.

### Para utilizar

### Como usar

Adicione a library

    $ composer require jansenfelipe/cep-gratis
    
Adicione o autoload.php do composer no seu arquivo PHP.

    require_once 'vendor/autoload.php';  

Agora basta chamar o metodo consultar($cep)

    $endereco = JansenFelipe\CepGratis\CepGratis::consultar('31030080'); 
