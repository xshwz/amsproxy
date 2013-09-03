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

    public function init() {
        $this->setting = Setting::model()->find();

        if ($this->isLogged()) {
            define('IS_LOGGED', true);

            /** 获取未读消息 */
            $this->unReadMsg = Message::model()->findAll(array(
                'condition' => 'receiver=:receiver AND state=1',
                'params' => array(
                    ':receiver' => $_SESSION['student']['sid'],
                ),
            ));
        }
        else
            $this->loginByCookies();
    }

    /**
     * 通过cookie登录
     */
    public function loginByCookies() {
        if ( isset($_COOKIE['ams_xsh_proxy_sid'])
            && isset($_COOKIE['ams_xsh_proxy_pwd'])
        ) {
            $rem = $this->getRemember();
            try {
                $this->login($rem[0], $rem[1], true);
                $this->redirect(array('Home/index'));
            }
            catch(Exception $e) {
                $this->destroy_remember();
            }
        }
    }


    /**
     * 登录
     * @param string $sid 学号
     * @param string $pwd 密码
     * @param mixed $is_remember 是否记住登录
     * @access public
     */
    public function login($sid, $pwd, $is_remember=false) {
        $amsProxy = new AmsProxy($sid, $pwd);

        if ($student = $this->getStudent($sid)) {
            $studentInfo = json_decode($student->info, true);
        } else {
            $studentInfo = $amsProxy->getStudentInfo();
            $this->saveStudent($sid, $pwd, $studentInfo);
        }

        $_SESSION['student'] = array(
            'sid' => $sid,
            'pwd' => $pwd,
            'info' => $studentInfo,
        );

        if ($is_remember)
            $this->remember($sid, $pwd);

        $this->redirect(array('home/index'));
    }


    /**
     * @return bool 是否已经登录
     */
    public function isLogged() {
        return isset($_SESSION['student']);
    }

    /**
     * 记住登录状态
     * @param string $sid 学号
     * @param string $pwd 密码
     * @param int $pwd 保存时间，默认5年
     * @access public
     */
    public function remember($sid, $pwd, $time=157680000) {
        setcookie('ams_xsh_proxy_sid',
            $this->encrypt($this->setting['crypt_key'], $sid), time() + $time);
        setcookie('ams_xsh_proxy_pwd',
            $this->encrypt($this->setting['crypt_key'], $pwd), time() + $time);
    }

    /**
     * 销毁remember cookie
     */
    public function destroy_remember() {
        setcookie('ams_xsh_proxy_sid', '', time() - 1000);
        setcookie('ams_xsh_proxy_pwd', '', time() - 1000);
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
}
