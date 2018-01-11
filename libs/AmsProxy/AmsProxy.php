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
     * @var string
     */
    public $baseUrl;

    /**
     * @var string
     */
    public $schoolcode;

    public $isTestOk = false;
    
    public $orcApi = 'http://meanchun.com/wb/wbocr/wbocr.php?url=';

    /**
     * @param string $session
     */
    public function __construct($session=null) {
        $this->curl = new curl_request;
        $this->curl->setTimeout(4);
        $this->baseUrl = Yii::app()->params['baseUrl'];
        $this->schoolcode = Yii::app()->params['schoolcode'];
        if($session != null)
            $this->setSession($session);
    }

    /**
     * @param string $captcha
     * @return string error message
     */
    public function login($sid, $pwd, $captcha) {
        $_hash = function($s) {
            return strtoupper(substr(md5($s), 0, 30));
        };
        $responseText = $this->POST(
            '_data/Index_LOGIN.aspx',
            array(
                'Sel_Type' => 'STU',
                'txt_asmcdefsddsd'   => $sid,
                'txt_pewerwedsdfsdff' => urlencode($pwd),
                'txt_sdertfgsadscxcadsads' => $captcha,
                'fgfggfdgtyuuyyuuckjg' => $_hash($_hash(strtoupper($captcha)) . $this->schoolcode),
                'dsdsdsdsdxcxdfgfg' => $_hash($sid . $_hash($pwd) . $this->schoolcode),
            )
        );

        if (!strpos($responseText, '正在加载权限数据')) {
            preg_match(
                '/color:Red;">(.*?)</', $responseText, $matches);
            if (isset($matches[1])) {
                return $matches[1];//这里输出验证码错误还有密码错误信息
            } else {
                return '系统错误，无法登录';
            }
        } else {
            $this->sid = $sid;
        }
    }
    
    public function testCurl(){//还有就是会多次测试,其实只要每个updateget一次权限就可以了
        // var_dump($this->isTestOk);
        if(!$this->isTestOk){
            $month = (int) date('m');
            $year = (int) date('Y');
            if ($month <= 7)
                $year -= 1;
            $result = $this->POST(
                'xscj/c_ydcjrdjl_rpt.aspx',
                array(
                    'sel_xnxq'   => $year.($month < 3 || $month > 7 ? '0' : '1'),
                    'radCx'      => 1,
                    'btn_search' => '%BC%EC%CB%F7'
                )
            );
            // echo "<pre>{$result}</pre>";
            if(strpos($result, '系统提示：您无权访问此页') !== false || $result == ''){
                return false;
            }
        }
        return $this->isTestOk = true;
    }
    /**
     * _login 旧版登陆接口
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
    public function GETRaw($url, $params=null, $referer=null) {
        return $this->requestRaw('get', $url, $params, null, $referer);
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

    public function requestRaw(
        $method, $url, $params=null, $data=null, $referer=null) {

        if (!$referer)
            $referer = $this->baseUrl . $url;

        return $this->curl->request(
                array(
                    'method'  => $method,
                    'url'     => $this->baseUrl . $url,
                    'params'  => $params,
                    'data'    => $data,
                    'headers' => array(
                        'Referer' => $referer,
                    ),
                )
            )->body;
    }
    /**
     * @return string
     */
    public function getSession() {
        if (!isset($this->curl->cookies['ASP.NET_SessionId'])){
            $this->GET('_data/LOGIN_NEW.ASPX');
            if (!isset($this->curl->cookies['ASP.NET_SessionId'])){
                return $this->generateSessionId();
            }
        }
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
                'headers' => array(
                    'Referer' => $this->baseUrl . '_data/home_login.aspx ',
                ),
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
    public function invoke($functionName, $args=null) {//应该设置__call方法的使用起来是更加自然
        if (!class_exists($functionName, false))//好像我有比原作更方便的加载方法哦~
            include 'functions/' . $functionName . '.php';

        $function = new $functionName($this, $args);
        return $function->run();
    }

    protected function generateSessionId() {
        $str = '012345abcdefghijklmnopqrstuvwxyz';
        $result = '';
        for ($i=0; $i < 24; $i++) {
            $result .= $str[rand(0, strlen($str)-1)];
        }
        return $result;
    }
}
