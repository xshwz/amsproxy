<?php
/**
 * 帮助控制器
 */
class HelpController extends StudentController {
    public function actionFeedback() {
        $this->pageTitle = '反馈';
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

    public function actionAbout() {
        $this->pageTitle = '关于';
        $this->render('about');
    }

    public function actionFAQ() {
        $this->pageTitle = 'FAQ';
        $this->render('FAQ');
    }
}
