<?php
class MessageController extends AdminController {
    public function actionSend() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Message::send(0, $_POST['receiver'], $_POST['message']);

            if (isset($_POST['reply'])) {
                $message = Message::model()->findByPk($_POST['reply']);

                if ($message->state)
                    $message->state = 0;

                $message->save();
            }
        } else {
            $this->render('send');
        }
    }

    public function actionEdit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['id']) && isset($_POST['message'])) {
                $message = Message::model()->findByPk($_POST['id']);
                $message->message = $_POST['message'];
                $message->save();
            }
        } else {
            $this->render('edit');
        }
    }
}
