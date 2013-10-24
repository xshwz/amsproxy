<?php
/**
 * 基控制器，为了统一管理，所有的控制器都应该直接或间接继承自该控制器
 */
class BaseController extends CController {
    /**
     * stylesheet
     *
     * @var string
     */
    public $_style = '';

    /**
     * @var Setting
     */
    public $setting;

    /**
     * @var Student
     */
    public $student;

    /**
     * @var Mcrypt
     */
    public $mcrypt;

    public function init() {
        $this->setting = Setting::model()->find();
        $this->mcrypt = new Mcrypt($this->setting['crypt_key']);

        if ($this->isLogged())
            $this->initStudent();
        else
            $this->loginFromCookie();
    }

    public function initStudent() {
        $this->student = Student::model()->findByPk(
            $_SESSION['student']['sid']);
        $this->student->last_login_time = date('Y-m-d H:i:s');
        $this->student->save();

        if (!isset($_SESSION['unread']))
            $_SESSION['unread'] = Message::unread(
                $_SESSION['student']['sid']);
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
            $this->saveStudent($amsProxy);
            $_SESSION['student'] = array(
                'sid'     => $sid,
                'pwd'     => $pwd,
                'session' => $amsProxy->getSession(),
            );

            if ($remember) $this->remember($sid, $pwd);

            return true;
        } else {
            return false;
        }
    }

    public function loginFromCookie() {
        if (isset($_COOKIE['sid']) && isset($_COOKIE['pwd'])) {
            $sid = $this->decrypt($_COOKIE['sid']);
            $pwd = $this->decrypt($_COOKIE['pwd']);

            if ($this->login($sid, $pwd))
                $this->initStudent();
            else
                $this->destroyRemember();
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

    public function isLogged() {
        return isset($_SESSION['student']);
    }

    /**
     * @param string
     * @return string
     */
    public function decrypt($s) {
        return rtrim($this->mcrypt->decrypt(urldecode($s)));
    }

    /**
     * @param AmsProxy $amsProxy
     * @param string $archives
     */
    public function saveStudent($amsProxy) {
        if (Student::model()->findByPk($amsProxy->sid) == null) {
            $student = new Student;
            $student->sid = $amsProxy->sid;
            $student->archives = json_encode(
                $amsProxy->invoke('getArchives'));
            $student->save();
        }
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
}
