<?php

namespace JansenFelipe\CepGratis\Clients;

use JansenFelipe\CepGratis\Contracts\HttpClientContract;

class CurlHttpClient implements HttpClientContract
{
    /**
     * @var resource
     */
    private $multi;

    /**
     * @var resource[]
     */
    private $curls = [];

    /**
     * @var string[]
     */
    private $headers = [];

    /**
     * CurlHttpClient constructor.
     */
    public function __construct()
    {
        $this->multi = curl_multi_init();
    }

    /**
     * Send GET request.
     *
     * @return string|null
     */
    public function get($uri)
    {
        if (!isset($this->curls[$uri])) {
            $this->curls[$uri] = $this->createCurl($uri);

            curl_multi_add_handle($this->multi, $this->curls[$uri]);
        }

        if (count($this->curls) != $this->multiExec() && curl_getinfo($this->curls[$uri], CURLINFO_HTTP_CODE) != 0) {
            return curl_multi_getcontent($this->curls[$uri]);
        }
    }

    /**
     * Send POST request.
     *
     * @return string
     */
    public function post($uri, $data = [])
    {
        if (!isset($this->curls[$uri])) {
            $this->curls[$uri] = $this->createCurl($uri, $data);

            curl_multi_add_handle($this->multi, $this->curls[$uri]);
        }

        if (count($this->curls) != $this->multiExec() && curl_getinfo($this->curls[$uri], CURLINFO_HTTP_CODE) != 0) {
            return curl_multi_getcontent($this->curls[$uri]);
        }
    }

    /**
     * Cria resource cURL.
     *
     * @param $uri
     * @param array $data
     *
     * @return resource
     */
    private function createCurl($uri, array $data = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => $uri,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        return $curl;
    }

    /**
     * Execute cURL.
     *
     * @return int
     */
    private function multiExec()
    {
        curl_multi_exec($this->multi, $qtd);
        curl_multi_select($this->multi);

        return $qtd;
    }

    /**
     * Set headers request.
     *
     * @param string $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }
}
