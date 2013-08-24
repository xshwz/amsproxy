<?php
/**
 * 基控制器，需要登录验证，要进行学生相关操作请继承该控制器
 */
class StudentController extends BaseController {
    /**
     * @var AmsProxy
     */
    public $amsProxy;

    public function init() {
        parent::init();
        if (defined('IS_LOGGED')) {
            $this->amsProxy = new AmsProxy(
                $_SESSION['student']['sid'],
                $_SESSION['student']['pwd']);
        } else {
            $this->notLoggedHandle();
        }
    }

    /**
     * 未登录的处理
     */
    public function notLoggedHandle() {
        $this->redirect(array('site/login'));
    }
}
