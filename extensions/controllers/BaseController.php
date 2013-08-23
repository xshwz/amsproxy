<?php
/**
 * 基控制器，为了统一管理，所有的控制器都应该直接或间接继承自该控制器
 */
class BaseController extends CController {
    public function init() {
        if ($this->isLogged()) define('IS_LOGGED', true);
    }

    /**
     * @return bool 是否已经登录
     */
    public function isLogged() {
        return isset($_SESSION['student']);
    }
}
