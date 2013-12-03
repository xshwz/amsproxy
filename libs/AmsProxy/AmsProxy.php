<?php
include 'cUrl/Request.php';
include 'functions/__base__.php';

class AmsProxy {
    /**
     * @var string
     */
    public $sid;

    /**
     * @var string
     */
    public $pwd;

    /**
     * @var Request
     */
    public $curl;

    /**
     * @var array
     */
    public $config = array(
        'baseUrl' => 'http://210.36.64.98/',
    );

    /**
     * @param string $sid
     * @param string $pwd
     * @param string $session
     * @param array $config
     */
    public function __construct($u, $config=null) {
        $this->sid = $u['sid'];
        $this->pwd = $u['pwd'];
        $this->updateConfig($config);
        $this->curl = new cUrl\Request;

        if (isset($u['session']))
            $this->setSession($u['session']);
    }

    /**
     * @return bool
     */
    public function login() {
        $responseText = $this->POST(
            '_data/Index_LOGIN.aspx',
            array(
                'Sel_Type' => 'STU',
                'UserID' => $this->sid,
                'PassWord' => $this->pwd,
            )
        );

        if (strpos($responseText, '正在加载权限数据'))
            return true;
        else
            return false;
    }

    /**
     * @param string $url
     * @param array $params url params
     * @return string
     */
    public function GET($url, $params=null) {
        return $this->request('get', $url, $params);
    }

    /**
     * @param string $url
     * @param array $data post data
     * @param array $params url params
     * @return string
     */
    public function POST($url, $data, $params=null) {
        return $this->request('post', $url, $params, $data);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $params url params
     * @param array $data post data
     * @return string
     */
    public function request($method, $url, $params=null, $data=null) {
        $responseText = iconv(
            'gb18030', 'utf-8//ignore',
            $this->curl->request(
                array(
                    'method' => $method,
                    'url'    => $this->config['baseUrl'] . $url,
                    'params' => $params,
                    'data'   => $data,
                )
            )->body
        );

        if (strpos($responseText, '您无权访问此页')) {
            $this->login();
            $responseText = $this->request($method, $url, $params, $data);
        }

        return $responseText;
    }

    /**
     * @param array $config
     */
    public function updateConfig($config) {
        foreach (array_keys($this->config) as $key) {
            if (isset($config[$key]))
                $this->config[$key] = $config[$key];
        }
    }

    /**
     * @return string
     */
    public function getSession() {
        return $this->curl->cookies['ASP.NET_SessionId'];
    }

    /**
     * @param string $session
     */
    public function setSession($session) {
        $this->curl->setCookies(array('ASP.NET_SessionId' => $session));
    }

    /**
     * @param string $function
     * @param mixed $args
     */
    public function invoke($functionName, $args=null) {
        if (!class_exists($functionName, false))
            include 'functions/' . $functionName . '.php';

        $function = new $functionName($this, $args);
        return $function->run();
    }
}
