<?php

/**
 * 登陆控制器，登录的验证和记住用户的登录。
 */
class LoginController extends BaseController {

    public function init() {
        parent::init();

        if (!defined('IS_LOGGED')) {
            $this->loginByCookies();
        }
    }


    /**
     * 登录
     * @param string $sid 学号
     * @param string $pwd 密码
     * @param mixed $is_remember 是否记住登录
     * @return boolean 是否登陆成功
     * @access public
     */
    public function login($sid, $pwd, $is_remember=false) {
        try {
            $amsProxy = new AmsProxy($sid, $pwd);

            $_SESSION['student'] = array(
                'sid' => $sid,
                'pwd' => $pwd,
                'info' => $this->getStudentInfo($sid),
            );
            define('IS_LOGGED', true);
            if ($is_remember)
                $this->remember($sid, $pwd);
        }
        catch(Exception $e) {
            echo $e->getMessage();
            echo $sid;
            return false;
        }
        return true;
    }

    /**
     * 通过cookie登录
     */
    public function loginByCookies() {
        if ( isset($_COOKIE['ams_xsh_proxy_sid'])
            && isset($_COOKIE['ams_xsh_proxy_pwd'])
        ) {
            $rem = $this->getRemember();
            if (!$this->login($rem[0], $rem[1], true))
                $this->destroy_remember();
                // $this->redirect(array('home/index'));
            // else
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
     * 保存学生到数据库
     * @param string $sid 学号
     * @param string $pwd 密码
     * @param string $studentInfo 学生信息
     * @return bool
     */
    public function saveStudent($sid, $pwd, $studentInfo) {
        $student = new Student;
        $student->sid = $sid;
        $student->pwd = md5($pwd);
        $student->info = json_encode($studentInfo);
        $student->save();
    }

    /**
     * 获取学生信息，先尝试从数据库中读取，如果数据库中没有数据，则从教务系统获取
     * @param string $sid 学号
     * @return $array 学生信息
     */
    public function getStudentInfo($sid) {
        if ($student = Student::model()->findByPk($sid)) {
            $studentInfo = json_decode($student->info, true);
        } else {
            $studentInfo = $amsProxy->getStudentInfo();
            $this->saveStudent($sid, $pwd, $studentInfo);
        }
        return $studentInfo;
    }
}
