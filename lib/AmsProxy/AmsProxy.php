<?php
include 'Parser.php';

/**
 * 教务系统代理
 */
class AmsProxy {
    /**
     * 学号
     * @var array
     */
    public $uid;

    /**
     * 密码
     * @var array
     */
    public $pwd;

    /**
     * HttpRequest object
     * @var object
     */
    public $httpRequest;

    /**
     * 配置
     * @var array
     */
    public $config = array(
        'baseUrl' => 'http://ams.gxun.edu.cn/',
    );

    /**
     * @param string $uid 学号
     * @param string $pwd 密码
     * @param array $config 配置
     */
    public function __construct($uid, $pwd, $config=null) {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->updateConfig($config);
        $this->httpRequest = new HttpRequest();
        $this->httpRequest->enableCookies();
        $this->login();
    }

    /**
     * 登录教务系统
     * @return bool
     */
    public function login() {
        $responseText = $this->POST(
            '_data/Index_LOGIN.aspx',
            array(
                'Sel_Type' => 'STU',
                'UserID' => $this->uid,
                'PassWord' => $this->pwd,
            ));
        if (!strpos($responseText, '正在加载权限数据'))
            throw new Exception('User ID or password is incorrect');
    }

    /**
     * @return array 学生信息
     */
    public function getStudentInfo() {
        $parser = new Parser($this->GET('xsxj/Stu_MyInfo_RPT.aspx'));
        return $parser->studentInfo();
    }

    /**
     * @param bool 是否是有效成绩
     * @return array 成绩表
     */
    public function getScore($effective=true) {
        $responseText = $this->POST(
            'xscj/Stu_MyScore_rpt.aspx',
            array(
                'SJ'       => (int)$effective,
                'SelXNXQ'  => '0',
                'txt_xm'   => '',
                'zfx_flag' => '0',
                'zxf'      => '0'));
        $parser = new Parser($responseText);
        if ($effective) return $parser->effectiveScore();
        else return $parser->originalScore();
    }

    /**
     * 返回学生成绩分部
     * @access public
     * @return void
     */
    public function getScoreDist() {
        $responseText = $this->POST(
            'xscj/Stu_cjfb_rpt.aspx',
            array( 'SelXNXQ'   => 0 ));
        $parser = new Parser($responseText);
        return $parser->distributionScore();
    }

    /**
     * 向教务系统发送一个 get http 请求
     * @param string $url
     * @param array $params url 参数
     * @return string
     */
    public function GET($url, $params=null) {
        return $this->request(HttpRequest::METH_GET, $url, $params);
    }

    /**
     * 向教务系统发送一个 post http 请求
     * @param string $url
     * @param array $data post 数据
     * @param array $params url 参数
     * @return string
     */
    public function POST($url, $data, $params=null) {
        return $this->request(HttpRequest::METH_POST, $url, $params, $data);
    }

    /**
     * 向教务系统发送一个 http 请求
     * @param string $url
     * @param array $params url 参数
     * @param array $data post 数据
     * @return string
     */
    public function request($method, $url, $params=null, $data=null) {
        $this->httpRequest->setMethod($method);
        $this->httpRequest->setUrl($this->config['baseUrl'] . $url);
        $this->httpRequest->setQueryData($params);
        $this->httpRequest->setPostFields($data);
        $this->httpRequest->send();
        $responseText = $this->httpRequest->getResponseBody();
        $responseText = iconv('gb18030', 'utf-8//ignore', $responseText);
        return $responseText;
    }

    /**
     * 更新配置
     * @param array $config 新配置
     */
    public function updateConfig($config) {
        foreach (array_keys($this->config) as $key) {
            if (isset($config[$key]))
                $this->config[$key] = $config[$key];
        }
    }
}
