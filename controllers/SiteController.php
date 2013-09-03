<?php
/**
 * 默认控制器
 */
class SiteController extends LoginController {
	public function actionIndex() {
		$this->render('index');
	}

    public function actionLogin() {
        if (defined('IS_LOGGED')) {
            $this->render('logged');
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sid = $_POST['sid'];
            $pwd = $_POST['pwd'];

            $is_remember = isset($_POST['remember'])
                && $_POST['remember'] == 'on';

            if ( $this->login($sid, $pwd, $is_remember) ) {
                $this->redirect(array('home/index'));
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
