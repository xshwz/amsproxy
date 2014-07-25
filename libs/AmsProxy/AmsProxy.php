<?php
include 'curl.php';
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
    public $baseUrl = 'http://ams.gxun.edu.cn/';

    /**
     * @param string $session
     */
    public function __construct($session=null) {
        $this->curl = new curl_request;
        $this->curl->setTimeout(8);
        $session = $session ? $session : $this->generateSessionId();
        $this->setSession($session);
    }

    /**
     * @param string $captcha
     * @return string error message
     */
    public function login($sid, $pwd, $captcha) {
        $responseText = $this->POST(
            '_data/Index_LOGIN.aspx',
            array(
                'Sel_Type' => 'STU',
                'txt_asmcdefsddsd'   => $sid,
                'txt_pewerwedsdfsdff' => urlencode($pwd),
                'txt_sdertfgsadscxcadsads' => $captcha,
                'fgfggfdgtyuuyyuuckjg' => $this->md5($this->md5(strtoupper($captcha)) . '10608'),
                'dsdsdsdsdxcxdfgfg' => $this->md5($sid . $this->md5($pwd) . '10608'),
            )
        );

        if (!strpos($responseText, '正在加载权限数据')) {
            preg_match(
                '/<font color="Red">(.*?)</', $responseText, $matches);
            if (isset($matches[1])) {
                return $matches[1];
            } else {
                return '系统错误，无法登录';
            }
        } else {
            $this->sid = $sid;
        }
    }

    /**
     * @return string error message
     */
    public function _login($sid, $pwd) {
        $responseText = $this->POST(
            '_data/Index_LOGIN_tfc.aspx',
            array(
                'Sel_Type' => 'STU',
                'UserID'   => $sid,
                'PassWord' => $pwd,
            )
        );

        if (!strpos($responseText, '正在加载权限数据')) {
            return '由于教务系统更新，导致相思青果暂时无法提供服务 :(';
        } else {
            $this->sid = $sid;
        }
    }

    /**
     * @param string $url
     * @param array $params url params
     * @param string $referer header referer
     * @return string
     */
    public function GET($url, $params=null, $referer=null) {
        return $this->request('get', $url, $params, null, $referer);
    }

    /**
     * @param string $url
     * @param array $data post data
     * @param array $params url params
     * @param string $referer header referer
     * @return string
     */
    public function POST($url, $data, $params=null, $referer=null) {
        return $this->request('post', $url, $params, $data, $referer);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $params url params
     * @param array $data post data
     * @param string $referer header referer
     * @return string
     */
    public function request(
        $method, $url, $params=null, $data=null, $referer=null) {

        if (!$referer)
            $referer = $this->baseUrl . $url;

        return iconv(
            'gb18030', 'utf-8//ignore',
            $this->curl->request(
                array(
                    'method'  => $method,
                    'url'     => $this->baseUrl . $url,
                    'params'  => $params,
                    'data'    => $data,
                    'headers' => array(
                        'Referer' => $referer,
                    ),
                )
            )->body
        );
    }

    /**
     * @return string
     */
    public function getSession() {
        if (!isset($this->curl->cookies['ASP.NET_SessionId']))
            $this->GET('');

        return $this->curl->cookies['ASP.NET_SessionId'];
    }

    /**
     * @return string
     */
    public function getCaptcha() {
        return $this->curl->request(
            array(
                'method' => 'get',
                'url'    => $this->baseUrl . 'sys/ValidateCode.aspx',
            )
        )->body;
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

    protected function generateSessionId() {
        return substr(
            str_shuffle('012345abcdefghijklmnopqrstuvwxyz'), 0, 24);
    }

    public function md5($s) {
        return strtoupper(substr(md5($s), 0, 30));
    }
}
