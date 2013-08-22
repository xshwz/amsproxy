<?php
class HomeController extends StudentController {
	public function actionIndex() {
		$this->render('index');
	}

    public function actionLogout() {
        session_destroy();
        $this->redirect(array('site/login'));
    }
}
