<?php
/**
 * 帮助控制器
 */
class HelpController extends StudentController {
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
