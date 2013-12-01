<?php
class ApiController extends ProxyController {
    public function actionCourses() {
        echo json_encode($this->getCourse());
    }

    public function actionScores() {
        echo json_encode($this->getScore());
    }

    public function actionRankExam() {
        echo json_encode($this->getRankExam());
    }

    public function notLoggedHandler() {
        throw new CHttpException(403);
    }
}
