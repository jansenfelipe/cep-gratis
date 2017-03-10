<?php

    namespace JansenFelipe\CepGratis;

    use Exception;

    /**
     * CepNotFoundException
     *
     * Define a exception para cep não encontrado
     *
     * @author  Matheus Lopes Santos <fale_com_lopez@hotmail.com>
     * @version 1.0.0
     * @since   10/03/2017
     */
    class CepNotFoundException extends Exception
    {
        /**
         * @var string
         */
        protected $message = 'O cep informado não existe';
    }
