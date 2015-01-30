<?php
class HomeController extends ProxyController {
    public function actionIndex() {
        $this->render('index', array(
            'examArrangement' => $this->get('exam_arrangement')));
    }

    public function actionLogin() {
        echo 'true';
    }

    public function actionLogout() {
        session_destroy();
        $this->redirect(array('/proxy'));
    }

    public function actionFeedback() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (trim($_POST['message'])) {
                Message::send(
                    $_SESSION['student']['sid'], 0, $_POST['message']);
                $this->alert = array(
                    'type' => 'success',
                    'message' => '感谢你的反馈，我们会尽快处理并给你答复的。',
                );
            } else {
                $this->alert = array(
                    'type' => 'danger',
                    'message' => '请填写反馈内容',
                );
            }
        }

        $this->render('feedback');
    }

    public function actionMessage() {
        Message::model()->updateAll(
            array('state' => 0),
            'receiver=:receiver',
            array(
                ':receiver' => $_SESSION['student']['sid'],
            )
        );

        $this->unread = array();
        $this->render('message', array(
            'messages' => Message::model()->findAll(array(
                'condition' => 'receiver=:sid OR sender=:sid',
                'order' => 'time DESC',
                'params' => array(
                    ':sid' => $_SESSION['student']['sid'],
                ),
            )),
        ));
    }
}
