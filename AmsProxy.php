<?php

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
        'amsCharset' => 'gb2312', // 教务系统编码
        'studentDir' => 'student/', // 缓存目录
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
        $this->httpRequest->setCookies(array('ASP.NET_SessionId' => null));
        $responseText = $this->POST(
            '_data/Index_LOGIN.aspx',
            array(
                'Sel_Type' => 'STU',
                'UserID' => $this->uid,
                'PassWord' => $this->pwd));

        $successText = iconv(
            'utf-8', $this->config['amsCharset'], '正在加载权限数据');

        if (!strpos($responseText, $successText))
            throw new Exception('User ID or password is incorrect');
    }

    /**
     * @return array 学生信息
     */
    public function getStudentInfo() {
        $responseText = $this->GET('xsxj/Stu_MyInfo_RPT.aspx');
        $dom = $this->DOM($responseText);
        $table = $dom->getElementsByTagName('table')->item(0);
        $studentInfo = array();
        foreach ($table->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');
            for ($i = 1; $i < $tds->length; $i += 2) {
                $key = str_replace(' ', '', $tds->item($i - 1)->textContent);
                $value = str_replace(' ', '', $tds->item($i)->textContent);
                if ($value) $studentInfo[$key] = $value;
            }
        }
        return $studentInfo;
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

        $dom = $this->DOM($responseText);
        $tables = $dom->getElementsByTagName('table');

        if ($effective)
            return $this->parseEffectiveScore($tables);
        else
            return $this->parseOriginalScore($tables);
    }

    /**
     * 解析原始成绩表，数组结果
     * @param string $tables 原始成绩表
     * @return array 原始成绩表
     */
    public function parseOriginalScore($tables) {
        $score = array(
            'thead' => array(
                '课程/环节',
                '学分',
                '类别',
                '课程类别',
                '考核方式',
                '修读性质',
                '平时',
                '中考',
                '末考',
                '技能',
                '综合',
            ),
            'tbody' => array(),
        );

        for ($i = 1; $i < $tables->length; $i += 3) {
            $termName = $tables
                ->item($i)
                ->getElementsByTagName('td')
                ->item(0)
                ->textContent;
            $termName = substr($termName, 15);

            $termScore = $tables->item($i + 2);
            foreach ($termScore->getElementsByTagName('tr') as $tr) {
                $tds = $tr->getElementsByTagName('td');
                $score['tbody'][$termName][] = array(
                    $tds->item(1)->textContent,
                    $tds->item(2)->textContent,
                    $tds->item(3)->textContent,
                    $tds->item(4)->textContent,
                    $tds->item(5)->textContent,
                    $tds->item(6)->textContent,
                    $tds->item(7)->textContent,
                    $tds->item(8)->textContent,
                    $tds->item(9)->textContent,
                    $tds->item(10)->textContent,
                    $tds->item(11)->textContent,
                );
            }
        }

        return $score;
    }

    /**
     * 解析有效成绩表，返回数组结果
     * @param string $tables 有效成绩表
     * @return array 有效成绩表
     */
    public function parseEffectiveScore($tables) {
        $score = array(
            'thead' => array(
                '课程/环节',
                '学分',
                '类别',
                '课程类别',
                '考核方式',
                '修读性质',
                '成绩',
                '取得学分',
                '绩点',
                '学分绩点',
            ),
            'tbody' => array(),
        );

        foreach ($tables->item(2)->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');

            if ($term_name = trim($tds->item(0)->textContent)) {
                $termName = $term_name;
                $score['tbody'][$termName] = array();
            }

            $score['tbody'][$termName][] = array(
                $tds->item(1)->textContent,
                $tds->item(2)->textContent,
                $tds->item(3)->textContent,
                $tds->item(4)->textContent,
                $tds->item(5)->textContent,
                $tds->item(6)->textContent,
                $tds->item(7)->textContent,
                $tds->item(8)->textContent,
                $tds->item(9)->textContent,
                $tds->item(10)->textContent,
            );
        }

        return $score;
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
        // 教务系统返回的文本有可能存在无效字符，这会导致 DOM 解析失败
        // 暂时没有更好的办法……
        $responseText = iconv(
            $this->config['amsCharset'],
            'utf-8//ignore',
            $responseText);
        $responseText = iconv(
            'utf-8',
            $this->config['amsCharset'],
            $responseText);
        return $responseText;
    }

    /**
     * @param string $html
     * @return DOMDocument
     */
    public function DOM($html) {
        $html = str_replace('<br>', '', $html);
        $html = str_replace('&nbsp;', '', $html);
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        return $dom;
    }

    /**
     * 更新配置
     * @param array $config 新配置
     */
    public function updateConfig($config) {
        // TODO
    }
}
