<?php
class HelpController extends ProxyController {
    public function actionFeedback() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Message::send($_SESSION['student']['sid'], 0, $_POST['message']);
            $this->success('感谢你的反馈，我们会尽快处理并给你答复的。');
        } else {
            $this->render('feedback');
        }
    }

    public function actionFAQ() {
        $this->render('FAQ');
    }
}
