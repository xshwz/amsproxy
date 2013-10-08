<?php
/**
 * 基控制器，为了统一管理，所有的控制器都应该直接或间接继承自该控制器
 */
class BaseController extends CController {
    /**
     * @var array 未读信息
     */
    public $unReadMsg = array();

    /**
     * @var Setting 设置信息
     */
    public $setting;

    /**
     * 学生数据模型
     * @var Student
     */
    public $student;

    public function init() {
        $this->setting = Setting::model()->find();

        if ($this->isLogged())
            $this->initStudent();
        else
            $this->tryLoginByCookies();
    }

    /**
     * 初始化数据
     */
    public function initStudent() {
        /** 获取未读消息 */
        $this->unReadMsg = Message::model()->findAll(array(
            'condition' => 'receiver=:receiver AND state=1',
            'params' => array(
                ':receiver' => $_SESSION['student']['sid'],
            ),
        ));

        /** 获取学生个人数据 */
        $this->student = Student::model()->findByPk(
            $_SESSION['student']['sid']);

        $this->student->last_login_time = date('Y-m-d H:i:s');
        $this->student->save();
    }

    /**
     * 登录
     * @param string $sid 学号
     * @param string $pwd 密码
     * @param string $is_remember 是否记住登录
     * @access public
     * @return bool 是否登录成功
     */
    public function login($sid, $pwd, $is_remember=false) {
        try {
            $amsProxy = new AmsProxy($sid, $pwd);

            $this->tryAddStudent($sid, $pwd, $amsProxy->getStudentInfo());

            $_SESSION['student'] = array(
                'sid' => $sid,
                'pwd' => $pwd,
            );

            if ($is_remember)
                $this->remember($sid, $pwd);
        } catch(Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * 尝试通过cookie登录
     */
    public function tryLoginByCookies() {
        if ( isset($_COOKIE['ams_xsh_proxy_sid'])
            && isset($_COOKIE['ams_xsh_proxy_pwd'])
        ) {
            $rem = $this->getRemember();
            if ($this->login($rem[0], $rem[1], true))
                $this->initStudent();
            else
                $this->destroy_remember();
        }
    }

    /**
     * 记住登录状态
     * @access public
     * @param string $sid 学号
     * @param string $pwd 密码
     * @param int $time 保存时间，默认5年
     */
    public function remember($sid, $pwd, $time=157680000) {
        setcookie('ams_xsh_proxy_sid',
            $this->encrypt($this->setting['crypt_key'], $sid), time() + $time);
        setcookie('ams_xsh_proxy_pwd',
            $this->encrypt($this->setting['crypt_key'], $pwd), time() + $time);
    }

    /**
     * 读取用户cookie记录的帐号和密码
     * @access public
     * @return array array(帐号，密码)
     */
    public function getRemember() {
        return array(
            $this->decrypt(
                $this->setting['crypt_key'], $_COOKIE['ams_xsh_proxy_sid']),
            $this->decrypt(
                $this->setting['crypt_key'], $_COOKIE['ams_xsh_proxy_pwd']),
        );
    }

    /**
     * 销毁remember cookie
     */
    public function destroy_remember() {
        setcookie('ams_xsh_proxy_sid', '', time() - 1000);
        setcookie('ams_xsh_proxy_pwd', '', time() - 1000);
    }

    /**
     * @return bool 是否已经登录
     */
    public function isLogged() {
        return isset($_SESSION['student']);
    }

    /**
     * 尝试添加学生到数据库，没有这个学生时添加
     * @param string $sid 学号
     * @param string $pwd 密码
     * @param string $studentInfo 学生信息
     */
    public function tryAddStudent($sid, $pwd, $studentInfo) {
        if (Student::model()->findByPk($sid) == null) {
            $student = new Student;
            $student->sid = $sid;
            $student->pwd = md5($pwd);
            $student->info = json_encode($studentInfo);
            $student->save();
        }
    }

    /**
     * 读取学生信息
     * @access public
     * @return array 学生信息
     */
    public function getInfo() {
        return json_decode($this->student->info, true);
    }

    /**
     *  使用$key来加密字串
     *  @access public
     *  @param string $key 加密使用的密钥
     *  @param string $plain_text 被加密字串
     *  @return string 加密后的字串
     */
    public function encrypt($key, $plain_text) {
        $plain_text = trim($plain_text);
        $iv = substr(md5($key), 0,mcrypt_get_iv_size (MCRYPT_CAST_256,MCRYPT_MODE_CFB));
        $c_t = mcrypt_cfb (MCRYPT_CAST_256, $key, $plain_text, MCRYPT_ENCRYPT, $iv);
        return trim(chop(base64_encode($c_t)));
    }

    /**
     *  使用$key来解密字串
     *  @access public
     *  @param string $key 加密使用的密钥
     *  @param string $c_t 被解密的字串
     *  @return stirng 解密后的字串
     */
    public function decrypt($key, $c_t) {
        $c_t = trim(chop(base64_decode($c_t)));
        $iv = substr(md5($key), 0,mcrypt_get_iv_size (MCRYPT_CAST_256,MCRYPT_MODE_CFB));
        $p_t = mcrypt_cfb (MCRYPT_CAST_256, $key, $c_t, MCRYPT_DECRYPT, $iv);
        return trim(chop($p_t));
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
