<?php
/**
 * 个人主页控制器
 */
class HomeController extends StudentController {
    public function actionLogout() {
        session_destroy();
        $this->destroyRemember();
        $this->redirect(array('site/login'));
    }
}
