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
    }

    /**
     * @return bool 是否已经登录
     */
    public function isLogged() {
        return isset($_SESSION['student']);
    }
}
