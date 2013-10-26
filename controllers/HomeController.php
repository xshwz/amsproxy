<?php
/**
 * 个人主页控制器
 */
class HomeController extends StudentController {
    public function actionLogout() {
        session_destroy();
        $this->destroyRemember();
        $this->redirect(array('site/index'));
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
