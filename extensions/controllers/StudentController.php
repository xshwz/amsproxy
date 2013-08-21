<?php
class StudentController extends BaseController {
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

    public function notLoggedHandle() {
        $this->redirect(array('site/login'));
    }
}
