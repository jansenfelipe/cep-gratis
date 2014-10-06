<?php

namespace JansenFelipe\CepGratis;

class Facade extends Illuminate\Support\Facades\Facade\BaseFacade {

    protected static function getFacadeAccessor() {
        return 'cep_gratis';
    }

}
