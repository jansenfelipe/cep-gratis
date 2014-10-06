# CEP Grátis

----------------------
Com esse pacote você poderá realizar consultas de CEP no site dos correios gratuitamente.

### Para utilizar

Adicione no seu arquivo `composer.json` o seguinte registro na chave `require`

    "jansenfelipe/cep-gratis": "dev-master"

Execute

    $ composer update

## (Laravel)

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

Agora basta chamar

    $endereco = CepGratis::consultar('31030080');


### (No-Laravel)

Adicione o autoload.php do composer no seu arquivo PHP.

    require_once 'vendor/autoload.php';  

Agora basta chamar o metodo consultar($cep) da classe JansenFelipe\CepGratis

    $cepGratis = new JansenFelipe\CepGratis();
    $endereco = $cepGratis->consultar('31030080');