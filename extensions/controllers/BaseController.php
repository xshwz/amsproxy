<?php
class BaseController extends CController {
    public $layout = '/layouts/main';

    /**
     * @var string
     */
    public $pageTitle = '';

    /**
     * @var array
     */
    public $alert = null;

    /**
     * @var string javascript
     */
    public $script = '';

    /**
     * @var array unread messages
     */
    public $unread = array();

    /**
     * @var array view data
     */
    public $viewData = null;

    /**
     * @var Mcrypt
     */
    public $mcrypt;

    /**
     * @var Setting
     */
    public $setting;

    /**
     * @var string
     */
    public $baseUrl;

    /**
     * @var AmsProxy
     */
    public $amsProxy;

    public function init() {
        $this->setting = Setting::model()->find();
    }

    /**
     * @return string error message
     */
    public function login($sid, $pwd, $captcha=null, $force=false) {
        $student = Student::model()->findByPk($sid);

        if( ($captcha == null|| $captcha == '') && isset($student->sid) && $pwd == $student->pwd && !$force){
            $this->afterLogin($sid,$pwd,false);
        }elseif($captcha){
            if ($error = $this->AmsProxy()->login($sid, $pwd, $captcha)) {
                return $error;
            } else {
                $this->afterLogin($sid,$pwd,true);
            }
        }else{
            $count = 0;
            $url = 'public/img/captcha/'.$sid.'.jpg';
            $url = dirname(__FILE__).'/../../'.$url;
            do{
                $check = file_put_contents($url,$this->AmsProxy()->getCaptcha());
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->AmsProxy()->orcApi.'http://proxy.deepkolos.cn/img/captcha/'.$sid.'.jpg?t='.time());
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch, CURLOPT_TIMEOUT, "3");//单位为秒
                curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true); //完成重定向
                // curl_setopt($ch,CURLOPT_PROXY,'127.0.0.1:8887');//设置代理服务器
                // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);//若PHP编译时不带openssl则需要此行
                $captcha = curl_exec($ch);
                curl_close($ch); 

                // $error = $captcha;
                if(strlen($captcha) == 4)
                    if($error = $this->AmsProxy()->login($sid, $pwd, $captcha)){
                        ;
                    }else{
                        $this->afterLogin($sid,$pwd,true);
                    }
                else{
                    $error = '验证码错误！';
                    // echo '收到的验证码长度为:'.$captcha.'<br>';
                }
                $count++;
            }while($error == '验证码错误！' && $count < 5);
            // unlink($url);
            if($error != null)
                return $error;
        }
    }
    /**
     * @return bool
     */
    public function isLogged() {
        return isset($_SESSION['student']);
    }
    public function afterLogin($sid,$pwd,$setSession){
        $this->saveStudent($sid,$pwd);
        $this->updateStudentLastLoginTime(
            Student::model()->findByPk($sid));
        if($setSession)
            $_SESSION['session'] = $this->AmsProxy()->getSession();
        $_SESSION['student'] = array(
            'sid'     => $sid,
            'pwd'     => $pwd,
            'isAdmin' => $this->isAdmin($sid),
        );
    }
    public function saveStudent($sid,$pwd) {
        $student = Student::model()->findByPk($sid);
        if (!$student) {
            $student = new Student;
        }
        $student->sid = $sid;
        $student->pwd = $pwd;
        // $student->archives = json_encode($this->get_archives());
        $student->save();
    }

    /**
     * @param Student $student
     */
    public function updateStudentLastLoginTime($student) {
        $student->last_login_time = date('Y-m-d H:i:s');
        $student->save();
    }

    /**
     * @param string $sid
     * @return bool
     */
    public function isAdmin($sid='') {
        if (isset($_SESSION['student']['isAdmin']))
            return $_SESSION['student']['isAdmin'];

        if ($this->isSuperAdmin($sid))
            return true;
        else if ($student = Student::model()->findByPk($sid))
            return $student->is_admin == '1';
        else
            return false;
    }

    /**
     * @return AmsProxy
     */
    public function AmsProxy() {
        if ($this->amsProxy == null) {
            if (isset($_SESSION['session'])) {
                $this->amsProxy = new AmsProxy($_SESSION['session']);
            }
            else {
                $this->amsProxy = new AmsProxy;
                if($this->amsProxy->getSession())
                    $_SESSION['session'] = $this->amsProxy->getSession();
            }
        }

        return $this->amsProxy;
    }


    /**
     * @param string $sid
     * @return bool
     */
    public function isSuperAdmin($sid=null) {
        if (!$sid) {
            if ($this->isLogged()) $sid = $_SESSION['student']['sid'];
            else return false;
        }
        return in_array($sid, Yii::app()->params['superAdmin']);
    }

    public function render($view, $data=null, $return=false) {
        $this->viewData = $data;
        parent::render($view, $data, $return);
    }

    public function renderStyle() {
        if (!$this->getAction())
            return;

        $styleFile =
            $this->getViewPath() . '/' .
            Yii::app()->controller->action->id . '.css';

        if (file_exists($styleFile)) {
            echo '<style>';
            $this->renderFile($styleFile);
            echo '</style>';
        }
    }

    public function renderScript() {
        if (!$this->getAction())
            return;

        $scriptFile =
            $this->getViewPath() . '/' .
            $this->getAction()->id . '.js';

        if (file_exists($scriptFile))
            $this->script .= $this->renderFile(
                $scriptFile, $this->viewData, true);

        if ($this->script)
            echo '<script>' . $this->script . '</script>';
    }

    /**
     * alert success
     * @param string $message 消息
     */
    public function success($message) {
        $this->render('/common/alert', array(
            'type' => 'success',
            'message' => $message,
        ));
    }

    /**
     * alert warning
     * @param string $message 消息
     */
    public function warning($message) {
        $this->render('/common/alert', array(
            'type' => 'warning',
            'message' => $message,
        ));
    }

    /**
     * alert error
     * @param string $message 消息
     */
    public function danger($message) {
        $this->render('/common/alert', array(
            'type' => 'danger',
            'message' => $message,
        ));
    }

    /**
     * alert info
     * @param string $message 消息
     */
    public function information($message) {
        $this->render('/common/alert', array(
            'type' => 'info',
            'message' => $message,
        ));
    }

    /**
     * 计算目标日期距离开学经过了多少周，默认使用当前日期
     * 
     * @param string $date 
     * @return int
     */
    public function weekNumber($date=null) {
        if ($date)
            $now = strtotime($date);
        else
            $now = time();
        $start = strtotime($this->setting['start_date']);
        $week_offset  = (int)date('N',$start) - 1;
        $start_ajusted = $start - $week_offset * 86400;
        $day = ($now - $start_ajusted)/86400;
        $week = floor($day/7);
        return $week;
    }

    /**
     * return full url
     */
    public function createFullUrl($route, $params=array(), $ampersand='&') {
        return 'http://' . $_SERVER['HTTP_HOST'] . $this->createUrl(
            $route, $params, $ampersand);
    }

    public function noneNull(&$obj){
        return (isset($obj))?$obj:null;
    }//我觉得应该这个使用宏比较好吧

    /**
     * get request param with get or post
     *
     * @param string $param
     * @return string
     */
    public function param($param) {
        if (isset($_GET[$param]))
            return $_GET[$param];

        if (isset($_POST[$param]))
            return $_POST[$param];

        return '';
    }
}
