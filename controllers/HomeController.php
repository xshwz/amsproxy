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
            $message = new Message;
            $message->receiver = 0;
            $message->sender = $_SESSION['student']['sid'];
            $message->message = $_POST['message'];
            $message->time = date('Y-m-d H:i:s');
            $message->state = 1;
            $message->save();
            $this->render('feedbackSuccess');
        } else {
            $this->render('feedbackForm');
        }
    }
}
