<?php
class ApiController extends ProxyController {
    public function actionCourses() {
        $this->getData('course');
    }

    public function actionScores() {
        $this->getData('score');
    }

    public function actionRankExam() {
        $this->getData('rank_exam');
    }

    public function actionArchives() {
        $this->getData('archives');
    }

    public function actionExam() {
        $this->getData('exam_arrangement');
    }

    public function actionUpdate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['field']))
                $this->updateItem($_POST['field']);
            else
                $this->update($this->fields,$this->fileFields,true);

            echo 'true';
        }
    }

    /**
     * @param string $field
     */
    public function getData($field) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
            $this->updateItem($field);

        echo $this->get($field, false);
    }

    public function notLoggedHandler() {
        throw new CHttpException(403);
    }
}
