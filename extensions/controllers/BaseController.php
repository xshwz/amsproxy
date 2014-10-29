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
     * @return bool
     */
    public function isLogged() {
        return isset($_SESSION['student']);
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
