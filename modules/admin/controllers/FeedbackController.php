<?php
class FeedbackController extends AdminController {
    public function actionIndex() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $message = Message::model()->findByPk($_POST['id']);

            if (isset($_POST['state']))
                $message->state = 0;
            else
                $message->state = 1;

            $message->save();

            /** 重新获取未读消息 */
            $this->unread = Message::unread(0);
        }

        $_messages = Message::model()->findAll(array(
            'order' => 'time DESC',
        ));
        $messages = array();
        foreach ($_messages as $message) {
            if ($message->sender == 0 && $message->receiver != 0) {
                $messages[$message->receiver]['sender'] = $message->_receiver;
                $messages[$message->receiver]['session'][] = $message;
            }

            if ($message->sender != 0 && $message->receiver == 0) {
                $messages[$message->sender]['sender'] = $message->_sender;
                $messages[$message->sender]['session'][] = $message;
            }
        }

        $this->render('index', array('messages' => $messages));
    }
}
