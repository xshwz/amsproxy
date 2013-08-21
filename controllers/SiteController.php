<?php
class SiteController extends BaseController {
	public function actionIndex() {
		$this->render('index');
	}

    public function actionLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sid = $_POST['sid'];
            $pwd = $_POST['pwd'];
            try {
                $amsProxy = new AmsProxy($sid, $pwd);
                $_SESSION['student'] = array(
                    'sid' => $sid,
                    'pwd' => $pwd,
                    'info' => $amsProxy->getStudentInfo(),
                );
                $this->redirect(array('home/index'));
            } catch(Exception $e) {
                $this->render('login', array(
                    'error' => true,
                    'sid' => $sid,
                ));
            }
        } else {
            $this->render('login');
        }
    }

    public function actionAbout() {
		$this->render('about');
    }
}
