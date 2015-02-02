# CEP Grátis
[![Travis](https://travis-ci.org/jansenfelipe/cep-gratis.svg?branch=2.0)](https://travis-ci.org/jansenfelipe/cep-gratis)
[![Latest Stable Version](http://img.shields.io/packagist/v/jansenfelipe/cep-gratis.svg?style=flat)](https://packagist.org/packages/jansenfelipe/cep-gratis)
[![Total Downloads](http://img.shields.io/packagist/dt/jansenfelipe/cep-gratis.svg?style=flat)](https://packagist.org/packages/jansenfelipe/cep-gratis)
[![License](http://img.shields.io/packagist/l/jansenfelipe/cep-gratis.svg?style=flat)](https://packagist.org/packages/jansenfelipe/cep-gratis)

Com esse pacote você poderá realizar consultas de CEP no site dos correios gratuitamente.

### Para utilizar

Adicione no seu arquivo `composer.json` o seguinte registro na chave `require`

    "jansenfelipe/cep-gratis": "2.0.*@dev"

Execute

    $ composer update
    
Adicione o autoload.php do composer no seu arquivo PHP.

    require_once 'vendor/autoload.php';  

Agora basta chamar o metodo consultar($cep)

    use JansenFelipe\CepGratis\CepGratis as CepGratis;
    $endereco = CepGratis::consultar('31030080'); 

### Frameworks

##### (Laravel)

Abra seu arquivo `config/app.php` e adicione `'JansenFelipe\CepGratis\CepGratisServiceProvider'` ao final do array `$providers`

    'providers' => array(

        'Illuminate\Foundation\Providers\ArtisanServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        ...
        'JansenFelipe\CepGratis\CepGratisServiceProvider',
    ),

Adicione também `'CepGratis' => 'JansenFelipe\CepGratis\Facade'` no final do array `$aliases`

    'aliases' => array(

        'App'        => 'Illuminate\Support\Facades\App',
        'Artisan'    => 'Illuminate\Support\Facades\Artisan',
        ...
        'CepGratis'    => 'JansenFelipe\CepGratis\Facade',

    ),
