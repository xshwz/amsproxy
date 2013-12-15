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

    public function init() {
        $this->setting = Setting::model()->find();
        $this->mcrypt = new Mcrypt($this->setting['crypt_key']);
    }

    /**
     * @return bool
     */
    public function isLogged() {
        return isset($_SESSION['student']);
    }

    /**
     * @param string $sid
     * @param string $pwd
     * @param bool $remember
     * @return bool
     */
    public function login($sid, $pwd, $remember=true) {
        $amsProxy = new AmsProxy(array(
            'sid' => $sid,
            'pwd' => $pwd,
        ));

        if ($amsProxy->login()) {
            $this->trySaveStudent($amsProxy);
            $_SESSION['student'] = array(
                'sid'     => $sid,
                'pwd'     => $pwd,
                'session' => $amsProxy->getSession(),
                'isAdmin' => $this->isAdmin($sid),
            );

            if ($remember) $this->remember($sid, $pwd);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $sid
     * @return bool
     */
    public function isAdmin($sid='') {
        if (isset($_SESSION['student']['isAdmin']))
            return $_SESSION['student']['isAdmin'];

        if ($student = Student::model()->findByPk($sid))
            return $student->is_admin == '1';
        else
            return false;
    }

    /**
     * @param AmsProxy $amsProxy
     * @param string $archives
     */
    public function trySaveStudent($amsProxy) {
        if (Student::model()->findByPk($amsProxy->sid) == null) {
            $student = new Student;
            $student->sid = $amsProxy->sid;
            $student->archives = json_encode(
                $amsProxy->invoke('getArchives'));
            $student->save();
        }
    }

    /**
     * save sid and pwd to cookies
     *
     * @param string $sid
     * @param string $pwd
     * @param int $time 保存时间，默认30天
     */
    public function remember($sid, $pwd, $time=2592000) {
        setcookie('sid', $this->mcrypt->encrypt($sid), time() + $time);
        setcookie('pwd', $this->mcrypt->encrypt($pwd), time() + $time);
    }

    public function destroyRemember() {
        setcookie('sid', null, 1);
        setcookie('pwd', null, 1);
    }

    /**
     * @param string
     * @return string
     */
    public function decrypt($s) {
        return rtrim($this->mcrypt->decrypt(urldecode($s)));
    }

    public function render($view, $data=null, $return=false) {
        $this->viewData = $data;
        parent::render($view, $data, $return);
    }

    public function renderStyle() {
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
        $scriptFile =
            $this->getViewPath() . '/' .
            Yii::app()->controller->action->id . '.js';

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
     * 计算目标日期距离开学经过了多少周，默认使用当前日期
     * 
     * @param string $date 
     * @return int
     */
    public function weekNumber($date=null) {
        if ($date)
            $time = strtotime($date);
        else
            $time = time();

        $time -= strtotime($this->setting['start_date']);
        return (int)($time / 86400 / 7 + 1);
    }

    /**
     * return full url
     */
    public function createFullUrl($route, $params=array(), $ampersand='&') {
        return 'http://' . $_SERVER['HTTP_HOST'] . $this->createUrl(
            $route, $params, $ampersand);
    }

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
