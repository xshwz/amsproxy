<?php
/**
 * API 控制器
 */
class ApiController extends StudentController {
	public function actionIndex() {
        echo json_encode(array('course', 'score'));
	}

    public function actionCourse() {
        echo json_encode($this->getCourse());
    }

    public function actionScore() {
        echo json_encode($this->getScore(1));
    }

    public function actionUnread() {
        echo CJSON::encode(Message::unread($_SESSION['student']['sid']));
    }
}
