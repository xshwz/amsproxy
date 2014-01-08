<?php

class curl_request {
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
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout) {
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $timeout);
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
     * @param int $port
     */
    public function setPort($port) {
        curl_setopt($this->curl, CURLOPT_PORT, $port);
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
     * @param function $callback
     */
    public function request($options, $callback=null) {
        if (isset($options['method']))
            $this->setMethod($options['method']);

        if (isset($options['params']))
            $this->setUrl($options['url'], $options['params']);
        else
            $this->setUrl($options['url']);

        if (isset($options['port']))
            $this->setPort($options['port']);

        if (isset($options['data']))
            $this->setPostFields($options['data']);

        if (isset($options['cookies']))
            $this->setCookies($options['cookies']);

        if (isset($options['headers']))
            $this->setHeaders($options['headers']);

        $response = new curl_response(
            $this->send(), curl_getInfo($this->curl));

        $this->setCookies($response->cookies);

        if ($callback) $callback();

        return $response;
    }
}

class curl_response {
    /**
     * @var array
     */
    public $cookies = array();

    /**
     * @var array
     */
    public $headers = array();

    /**
     * @var string
     */
    public $header = '';

    /**
     * @var string
     */
    public $body = '';

    /**
     * @param string $response
     * @param array $info curl info
     */
    public function __construct($response, $info) {
        $this->header = substr($response, 0, $info['header_size'] - 4);
        $this->body = substr($response,  -$info['size_download']);

        $headers = explode("\r\n", $this->header);
        foreach ($headers as $header) {
            preg_match('/(.*?): (.*)/', $header, $matches);
            if (count($matches) == 3) {
                $key = strtolower($matches[1]);
                $value = $matches[2];

                if ($key == 'set-cookie') {
                    $cookie = explode('; ', $value);
                    preg_match('/(.*?)=(.*)/', $cookie[0], $matches);
                    $this->cookies[$matches[1]] = $matches[2];
                } else {
                    $this->headers[$key] = $value;
                }
            }
        }
    }

    public function json() {
        return json_decode($this->body);
    }

    public function __toString() {
        return $this->body;
    }
}
