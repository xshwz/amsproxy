<?php
/**
 * 个人主页控制器
 */
class HomeController extends StudentController {
	public function actionIndex() {
		$this->render('index');
	}

    public function actionLogout() {
        session_destroy();
        $this->redirect(array('site/login'));
    }

    public function actionFeedback() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $feedback = new Feedback;
            $feedback->sid = $_SESSION['student']['sid'];
            $feedback->msg = $_POST['msg'];
            $feedback->time = date('Y-m-d H:i:s');
            $feedback->save();
            $this->render('feedbackSuccess');
        } else {
            $this->render('feedbackForm');
        }
    }
}
