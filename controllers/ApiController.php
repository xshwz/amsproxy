<?php
/**
 * API 控制器
 */
class ApiController extends StudentController {
	public function actionIndex() {
        echo json_encode(array('course', 'score'));
	}

    public function actionCourse() {
        echo $this->getCourse(true);
    }

    public function actionScore() {
        echo $this->getScore(true);
    }
}
