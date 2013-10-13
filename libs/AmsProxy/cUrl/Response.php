<?php
namespace cUrl;

class Response {
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
