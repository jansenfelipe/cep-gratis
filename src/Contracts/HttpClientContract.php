<?php

namespace JansenFelipe\CepGratis\Contracts;

interface HttpClientContract
{
    /**
     * @return string
     */
    public function get($uri);

    /**
     * @return string
     */
    public function post($uri, $data = array());
}