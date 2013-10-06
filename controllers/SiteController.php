<?php
/**
 * 默认控制器
 */
class SiteController extends BaseController {
	public function actionIndex() {
		$this->render('index');
	}

    public function actionLogin() {
        if ($this->isLogged()) {
            $this->render('logged');
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sid = $_POST['sid'];
            $pwd = $_POST['pwd'];

            if ( $this->login($sid, $pwd, true) ) {
                $this->redirect(array('personal/archives'));
            } else {
                $this->render('login', array(
                    'error' => true,
                    'sid' => $sid,
                ));
            }
        }
        else {
            $this->render('login');
        }
    }

    public function actionAbout() {
		$this->render('about');
    }

    public function actionCompatibility() {
		$this->render('compatibility');
    }

}
