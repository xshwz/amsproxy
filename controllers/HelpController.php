<?php
/**
 * 帮助控制器
 */
class HelpController extends StudentController {
    public function actionFeedback() {
        $this->pageTitle = '反馈';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Message::send($_SESSION['student']['sid'], 0, $_POST['message']);
            $this->success('感谢你的反馈，我们会尽快处理并给你答复的。');
        } else {
            $this->render('feedback');
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
