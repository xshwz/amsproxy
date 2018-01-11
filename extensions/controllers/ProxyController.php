<?php
define('CACHE',dirname(__FILE__).'/../../public/img/cache/');

class ProxyController extends BaseController {
    /**
     * @var Student
     */
    public $common;

    public $student;

    //用于沟通main.tpl的数据,来实现局部更新的
    public $field = null;
    public $fileField = null;
    public $commonField = null;

    public $config;
    /**
     * @var array
     */
    public $commonFields = array(
        // 'rankExamForm',
    );
    public $fields = array(
        'archives',
        'scoreAffirm',
        'validScore',
        'GPA',
        'graduate_requirement',
        'exam_arrangement',
        'rank_exam',
        'theory_subject',
    );
    public $fileFields = array(
        'score',
        'scoreMinor',
        'validScoreImg',
        'classSchedule'
    );
    public function init() {
        parent::init();

        if (!$this->isLogged())
            $this->notLoggedHandler();
        
        global $config;
        if($config['params']['useCaptcha']){
            if(isset($_GET['refreshed']))
                if(!$this->AmsProxy()->testCurl()){
                    $lastsid = $_SESSION['student']['sid'];
                    $lastpwd = $_SESSION['student']['pwd'];

                    $_SESSION = array();
                    session_destroy();
                    session_start();

                    $this->AmsProxy()->curl->cookies['ASP.NET_SessionId'] = null;
                    unset($this->AmsProxy()->curl->cookies['ASP.NET_SessionId']);
                    $_SESSION['session'] = $this->AmsProxy()->getSession();
                    $this->AmsProxy()->setSession($_SESSION['session']);

                    $this->notLoggedHandler($lastsid,$lastpwd,'更新数据需要登陆一下下~');
                }
            
            if(isset($_GET['referer'])){
                $this->redirect(urldecode($_GET['referer']).'?refreshed=true');
            }
        }

        $this->student = Student::model()->findByPk(
            $_SESSION['student']['sid']);

        if(!$this->common = Common::model()->findByPk('common')){
            $this->common = new Common;
            $this->common->id = 'common';
            $this->common->save();
        }

        $this->unread = $this->getUnreadMessage();

        $this->update(array(
            'fields'=>array('archives'),
            'fileFields'=>array(),
            'commonFields'=>array(),
            'force'=>false
        ));
    }

    public function checkSession() {
        if (!isset($_SESSION['session'])) {
            if (isset($_COOKIE['session'])) {
                $_SESSION['session'] = $_COOKIE['session'];
            } else {
                setcookie(
                    'session', $this->AmsProxy()->getSession(),
                    time() + 3 * 356 * 60 * 60, '/');
            }
        }
    }

    public function notLoggedHandler($lastsid='', $lastpwd='',$message=null) {
        // setcookie('sessionchanged','true',time()+3600*24); // 现在改为一天
        // if(isset($_SESSION['lastLoginId']) && isset($_SESSION['lastLoginPw'])){
        //     $sid = $_SESSION['lastLoginId'];
        //     $pwd = $_SESSION['lastLoginPw'];
        //     if($student = Student::model()->findByPk($sid))
        //         if ($error = $this->login($sid, $pwd)) {
        //             $this->render('/common/login', array(
        //                 'error'   => $error,
        //                 'sid'     => $sid,
        //                 'pwd'     => $pwd,
        //                 'captcha' => '',
        //             ));

        //             Yii::app()->end();
        //         }
        // }
        global $config;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $sid = $_POST['sid'];
            $pwd = $_POST['pwd'];
            $captcha = (isset($_POST['captcha'])) ? $_POST['captcha'] : null;
            if ($error = $this->login($sid, $pwd, $captcha)) {
                $captchaImg = ($config['params']['useCaptcha'])?base64_encode($this->AmsProxy()->getCaptcha()):'';
                //其实如果第一次自动识别验证码失败时候直接转为人工输入好了
                $this->render('/common/login', array(
                    'error'   => $error,
                    'sid'     => $sid,
                    'pwd'     => $pwd,
                    'captcha' => $captchaImg,
                    'message' => $message
                ));

                Yii::app()->end();
            }
            $_SESSION['lastLoginId'] = $sid;
            $_SESSION['lastLoginPw'] = $pwd;
        } else {
            $captchaImg = ($config['params']['useCaptcha']) ? base64_encode($this->AmsProxy()->getCaptcha()) : '';
            // $sid = (isset($_SESSION['lastLoginId'])) ? $_SESSION['lastLoginId'] : '';
            // $pwd = (isset($_SESSION['lastLoginPw'])) ? $_SESSION['lastLoginPw'] : '';
            $this->render('/common/login', array(
                'sid'     => $lastsid,
                'pwd'     => $lastpwd,
                'captcha' => $captchaImg,
                'message' => $message
            ));

            Yii::app()->end();
        }
    }

    /**
     * @return array
     */
    public function getUnreadMessage() {
        return Message::unread($_SESSION['student']['sid']);
    }

    /**
     * @return array
     */
    public function get_archives() {
        return array_merge(
            $this->AmsProxy()->invoke('getArchives'),
            $this->AmsProxy()->invoke('getArchivesEx')
        );
    }
    public function get_rankExamForm() {
        return $this->AmsProxy()->invoke('getRankExamForm');
    }

    /**
     * @return array
     */
    public function get_score() {
        return $this->AmsProxy()->invoke('getScore');
    }
    public function get_scoreMinor() {
        return $this->AmsProxy()->invoke('getScoreMinor');
    }
    public function get_GPA() {
        return $this->AmsProxy()->invoke('getGPA');
    }
    public function get_graduate_requirement() {
        return $this->AmsProxy()->invoke('getGraduateRequirement');
    }
    public function get_scoreAffirm() {
        //获取行政班级
        // $archives = $this->get('archives');
        // $startYear = '20'.substr($archives->{'行政班级'},0,2);
         $startYear = '20'.substr($_SESSION['student']['sid'],0,2);//还是从学号提取吧
        return $this->AmsProxy()->invoke('getScoreAffirm',$startYear);
    }
    public function get_validScore() {
        return $this->AmsProxy()->invoke('getValidScore');
    }
    public function get_validScoreImg() {
        return $this->AmsProxy()->invoke('getValidScoreImg');
    }
    public function get_classSchedule() {
        return $this->AmsProxy()->invoke('getClassSchedule');
    }
    
    /**
     * @return array
     */
    public function get_course() {
        return array_merge(
            $this->AmsProxy()->invoke('getPersonalCourse'),
            $this->AmsProxy()->invoke(
                'getClassCourse', $this->get('archives')->{'行政班级'}));
    }

    /**
     * @return array
     */
    public function get_rank_exam() {
        return array(
            'score' => $this->AmsProxy()->invoke('getRankExamScore'),
        );
    }
    /**
     * @return array
     */
    public function get_theory_subject() {
        return $this->AmsProxy()->invoke('getTheorySubject');
    }

    public function get_exam_arrangement() {
        return $this->AmsProxy()->invoke('getExamArrangement');
    }

    public function update($config) {
        if(is_array($config)){
            $config = (object)$config;
            $force  = $this->noneNULL($config->force);
            $fields = $this->noneNULL($config->fields);
            $fileFields   = $this->noneNULL($config->fileFields);
            $commonFields = $this->noneNULL($config->commonFields);
            $this->updateItem('fields',$fields,$force);
            $this->updateItem('fileFields',$fileFields,$force);
            $this->updateItem('commonFields',$commonFields,$force);
        }
    }
    public function updateItem($func,$fields,$force){
        if(is_array($fields))
        foreach ($fields as $field){
            if ($force || !$this->{'checkCache_'.$func}($field)){
                $this->getAuthToUpdate();
                $this->{'update_'.$func}($field);
            }
        }
    }
    /**
     * @param string $field
     */
    public function update_fields($field) {
        $this->student->{$field} = json_encode($this->{'get_' . $field}());
        $this->student->save();
    }
    public function update_commonFields($field) {
        $this->common->{$field} = json_encode($this->{'get_' . $field}());
        $this->common->save();
    }
    public function update_fileFields($field) {
        return file_put_contents($this->cacheUrl($field),$this->{'get_' . $field}());
    }

    public function checkCache_fileFields($field){
        return file_exists($this->cacheUrl($field));
    }
    public function checkCache_fields($field){
        return $this->student->{$field};
    }
    public function checkCache_commonFields($field){
        return $this->common->{$field};
    }
    
    public function getCache($field){
        if(file_exists($this->cacheUrl($field)))
            return file_get_contents($this->cacheUrl($field));
        return '';
    }
    public function cacheUrl($field){
        return CACHE.$field.'/_hidden_'.$_SESSION['student']['sid'].'.jpg';
    }
    public function webUrl($field){
        return 'img/cache/'.$field.'/_hidden_'.$_SESSION['student']['sid'].'.jpg';
    }
    public function getAuthToUpdate(){
        if(!$this->AmsProxy()->testCurl()){
            global $config;
            // echo '还没有获取到获取权限~';
            $this->AmsProxy()->curl->cookies['ASP.NET_SessionId'] = null;
            unset($this->AmsProxy()->curl->cookies['ASP.NET_SessionId']);
            $_SESSION['session'] = $this->AmsProxy()->getSession();
            $this->AmsProxy()->setSession($_SESSION['session']);

            if($config['params']['useCaptcha']){
                $this->redirect('/?refreshed=true&referer='.urlencode($_SERVER['HTTP_REFERER']));
                die();
            }

            $error = $this->login($this->student->sid, $this->student->pwd, null,true);
            if($error){
                $this->warning('验证码自动识别失败了: '.$error.'~');
                Yii::app()->end();
            }
            return true;
        }
        // echo '以获取到权限了';
        return true;
    }
    /**
     * @param string $field
     * @param bool $json_encode
     * @return mixed
     */
    public function get($field, $type='fields') {//分类就会牵动很多的变化了,要么就通过数字含义进行路由
        //还是单独检查是否更新吧
        if ($type == 'fields')
            return json_decode($this->student->{$field});
        elseif($type == 'fileFields')//文件类,读取原数据
            return $this->getCache($field);
        elseif($type == 'commonFields'){
            return json_decode($this->common->{$field});
        }
    }
    public function getXNXQ() {
        return $this->getXN() . $this->getXQ();
    }
    public function getXN() {
        $month = (int) date('m');
        $year = (int) date('Y');
        $day = (int) date('d');
        if ($month < 7)
            $year -= 1;
        return $year;
    }
    public function getXQ() {
        $month = (int) date('m');
        $day = (int) date('d');
        return ( $month <= 2 || ($month >= 6) ) ? '0' : '1';
    }
    public function lastXN(){
        return (!$this->lastXQ())? $this->getXN() : $this->getXN() -1;
    }
    public function lastXQ(){
        return ($this->getXQ()) ? 0 : 1 ;
    }
}
