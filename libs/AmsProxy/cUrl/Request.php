<?php
namespace cUrl;
include 'Response.php';

class Request {
    /**
     * @var array
     */
    public $cookies = array();

    /**
     * @var array
     */
    public $headers = array();

    public function __construct() {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HEADER, true);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 8);
    }

    /**
     * @param string $url
     * @param array $params
     */
    public function setUrl($url, $params=null) {
        if ($params) $url .= '?' . http_build_query($params);
        curl_setopt($this->curl, CURLOPT_URL, $url);
    }

    /**
     * @param string $method
     */
    public function setMethod($method) {
        switch (strtolower($method)) {
            case 'get':
                curl_setopt($this->curl, CURLOPT_HTTPGET, true);
                break;

            case 'post':
                curl_setopt($this->curl, CURLOPT_POST, true);
                break;
        }
    }

    /**
     * @param array $data
     */
    public function setPostFields($data) {
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers) {
        $this->headers = array_merge($this->headers, $headers);
        foreach ($this->headers as $key => $value)
            $_headers[] = $key . ': ' . $value;
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $_headers);
    }

    public function send() {
        return curl_exec($this->curl);
    }

    /**
     * @param array $cookies
     */
    public function setCookies($cookies) {
        $this->cookies = array_merge($this->cookies, $cookies);
        $_cookies = array();
        foreach ($this->cookies as $key => $value)
            $_cookies[] = $key . '=' . $value;
        curl_setopt($this->curl, CURLOPT_COOKIE, join('; ', $_cookies));
    }

    /**
     * @param array $options
     */
    public function request($options) {
        if (isset($options['method']))
            $this->setMethod($options['method']);

        if (isset($options['params']))
            $this->setUrl($options['url'], $options['params']);
        else
            $this->setUrl($options['url']);

        if (isset($options['data']))
            $this->setPostFields($options['data']);

        if (isset($options['cookies']))
            $this->setCookies($options['cookies']);

        if (isset($options['headers']))
            $this->setHeaders($options['headers']);

        $response = new Response($this->send(), curl_getInfo($this->curl));
        $this->setCookies($response->cookies);
        return $response;
    }
}
