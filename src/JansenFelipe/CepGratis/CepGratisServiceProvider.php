<?php

namespace JansenFelipe\CepGratis;

use Illuminate\Support\ServiceProvider;

class CepGratisServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('JansenFelipe/cep-gratis');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('cep_gratis', function() {
            return new \JansenFelipe\CepGratis\CepGratis;
        });
    }

}
