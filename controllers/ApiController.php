<?php
/**
 * API 控制器
 */
class ApiController extends StudentController {
	public function actionIndex() {
        echo json_encode(array('course', 'score'));
	}

    public function actionCourse() {
        echo json_encode(array_merge(
            $this->amsProxy->getCourse(),
            $this->amsProxy->getClassCourse(
                $_SESSION['student']['info']['行政班级'])));
    }

    public function actionScore() {
        echo json_encode($this->amsProxy->getScore(1));
    }
}
