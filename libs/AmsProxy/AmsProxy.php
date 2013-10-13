<?php
include 'Parser.php';
include 'cUrl/Request.php';

/**
 * 教务系统代理
 */
class AmsProxy {
    /**
     * 学号
     * @var array
     */
    public $sid;

    /**
     * 密码
     * @var array
     */
    public $pwd;

    /**
     * @var Request
     */
    public $http;

    /**
     * 配置
     * @var array
     */
    public $config = array(
        'baseUrl' => 'http://ams.gxun.edu.cn/',
    );

    /**
     * @param string $sid 学号
     * @param string $pwd 密码
     * @param array $config 配置
     */
    public function __construct($sid, $pwd, $config=null) {
        $this->sid = $sid;
        $this->pwd = $pwd;
        $this->updateConfig($config);
        $this->http = new cUrl\Request;
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
                'UserID' => $this->sid,
                'PassWord' => $this->pwd,
            ));

        if (!strpos($responseText, '正在加载权限数据'))
            throw new Exception('User ID or password is incorrect');
    }

    /**
     * @return array 学籍档案
     */
    public function getArchives() {
        $responseText = $this->GET('xsxj/Stu_MyInfo_RPT.aspx');
        return $this->getParser($responseText)->archives();
    }

    /**
     * 修改学生个人信息
     * @param array $info 修改的信息
     */
    public function setStudentInfo($info) {
        $data = array(
            'vName0' => 'lxdh',
            'vName1' => 'cym',
            'vName2' => 'jg_id',
            'vName3' => 'lxdz',
            'vName4' => 'sjr',
            'vName5' => 'yzbm',
            'vName6' => 'zzmm_id',
            'vName7' => 'mobilephone',
            'vNU'    => '8',
            'txt0'   => '',
            'txt1'   => '',
            'txt2'   => '',
            'txt3'   => '',
            'txt4'   => '',
            'txt5'   => '',
            'txt6'   => '',
            'txt7'   => '',
        );
        // echo '<pre>';
        // var_dump($info);
        // echo '</pre>';
        foreach ($info as $key => $val) {
            $data[$key] = iconv('utf-8', 'gb18030', $val);
        }
        $this->POST('xsxj/Stu_EditMyInfo_rpt.aspx', $data);
    }

    /**
     * @param int $is_effective 1、有效成绩，0、原始成绩
     * @return array 成绩表
     */
    public function getScore($is_effective=1) {
        $responseText = $this->POST(
            'xscj/Stu_MyScore_rpt.aspx',
            array(
                'SJ'       => $is_effective,
                'SelXNXQ'  => 0,
                'txt_xm'   => null,
                'zfx_flag' => 0,
                'zxf'      => 0,
            ));
        $parser = new Parser($responseText);
        if ($is_effective) return $parser->effectiveScore();
        else return $parser->originalScore();
    }

    /**
     * @return array 学生成绩分布表
     */
    public function getScoreDist() {
        $responseText = $this->POST(
            'xscj/Stu_cjfb_rpt.aspx', array('SelXNXQ' => 0));
        return $this->getParser($responseText)->distributionScore();
    }

    /**
     * @return array 学生等级考试报名情况表
     */
    public function getRankExamSign() {
        $responseText = $this->GET('xscj/Stu_djksbm_rpt.aspx');
        return $this->getParser($responseText)->rankExamSign();
    }

    /**
     * 报名或取消等级考试
     * @param string $id 报名或取消按钮的id
     */
    public function enterRankExam($id) {
        $responseText = $this->GET('xscj/Stu_djksbm_rpt.aspx');
        $post = $this->getParser($responseText)->enterRankExamById($id);
        $this->POST('xscj/Stu_djksbm_rpt.aspx', $post);
    }

    /**
     * @return array 等级考试成绩表
     */
    public function getRankScore() {
        $responseText = $this->GET('xscj/Stu_djkscj_rpt.aspx');
        return $this->getParser($responseText)->rankScore();
    }

    /**
     * @param string sel_lc参数的内容,比如'2012102,'
     * @return array 考试安排
     */
    public function getExamArrange($sel_lc = null) {
        $responseJs = $this->GET('KSSW/Private/list_xnxqkslc.aspx');
        if ($sel_lc == null) {
            preg_match('/option\\s+value=[\'"](\\d+,)/', $responseJs, $matches);
            $sel_lc = $matches[1];
        }
        $responseText = $this->POST(
            'KSSW/stu_ksap_rpt.aspx', array('sel_lc' => $sel_lc));
        return $this->getParser($responseText)->examArrange();
    }

    /**
     * @return array 培养方案
     */
    public function getTrainPro() {
        return array(
            'theory' => $this->getTheorySubject(),
            'practice' => $this->getPracticeSubject(),
        );
    }

    /**
     * @return array 理论课程
     */
    public function getTheorySubject() {
        $responseText = $this->GET('jxjh/Stu_byfakc_rpt.aspx');
        return $this->getParser($responseText)->theorySubject();
    }

    /**
     * @return array 实践环节
     */
    public function getPracticeSubject() {
        $responseText = $this->GET('jxjh/Stu_byfahj_rpt.aspx');
        return $this->getParser($responseText)->practiceSubject();
    }

	
    /**
     * getTimetable 
     * 
     * @param string 年份, 如2010
     * @param string $term 学期, 0上学期, 1下学期
     * @param number $type 排版类型, 0按星期, 1按科目
     * @return array 课程安排表
     */
    public function getTimetable($year, $term, $type) {
        $responseText = $this->POST('znpk/Pri_StuSel_rpt.aspx', array(
            'Sel_XNXQ' => $year . $term,
            'rad'      => $type,
        ));
        return $this->getParser($responseText)->timetable($type);
    }

    /**
     * @param string $Sel_XNXQ 学期
     * @return array 原始未经处理的课程表
     */
    public function getOriginalCourse($Sel_XNXQ) {
        $responseText = $this->POST('znpk/Pri_StuSel_rpt.aspx', array(
            'Sel_XNXQ' => $Sel_XNXQ,
            'rad'      => 1,
            'px'       => 0,
        ));
        return $this->getParser($responseText)->course();
    }

    /**
     * @return array 课程表
     */
    public function getCourse($Sel_XNXQ='20130') {
        return $this->getParser()->coursesConvert(
            $this->getOriginalCourse($Sel_XNXQ));
    }

    /**
     * @param string $className 班级名称
     * @return array 班级课表
     */
    public function getClassCourse($className=null) {
        $responseText = $this->POST('ZNPK/KBFB_ClassSel_rpt.aspx', array(
            'Sel_XNXQ' => '20130',
            'Sel_XZBJ' => $this->getClassCode($className),
            'type'     => 2,
            'chkrxkc'  => 1,
        ));
        return $this->getParser($responseText)->classCourse();
    }

    /**
     * @param string $className 班级名称
     * @return array 班级课表
     */
    public function getClassCode($className) {
        $classInfo = $this->GET('ZNPK/Private/List_XZBJ.aspx', array(
            'xnxq' => '20130',
            'xzbj' => iconv('utf-8', 'gb18030', $className),
        ));
        preg_match('/option value=(\d+)/', $classInfo, $matches);
        return $matches[1];
    }

    /**
     * 向教务系统发送一个 get http 请求
     * @param string $url
     * @param array $params url 参数
     * @return string
     */
    public function GET($url, $params=null) {
        return $this->request('get', $url, $params);
    }

    /**
     * 向教务系统发送一个 post http 请求
     * @param string $url
     * @param array $data post 数据
     * @param array $params url 参数
     * @return string
     */
    public function POST($url, $data, $params=null) {
        return $this->request('post', $url, $params, $data);
    }

    /**
     * 向教务系统发送一个 http 请求
     * @param string $method
     * @param string $url
     * @param array $params url 参数
     * @param array $data post 数据
     * @return string
     */
    public function request($method, $url, $params=null, $data=null) {
        $responseText = $this->http->request(array(
            'method' => $method,
            'url' => $this->config['baseUrl'] . $url,
            'params' => $params,
            'data' => $data,
        ))->body;
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

    /**
     * @param string $html
     * @return Parser
     */
    public function getParser($html='') {
        return new Parser($html);
    }
}
