<?php
class CourseController extends ProxyController {
    public function actionTable() {
        $this->render('table', array('courses' => $this->getCourse()));
    }

    public function actionToday() {
        $this->render('today', array('courses' => $this->getCourse()));
    }

    public function actionTheorySubject() {
        $this->pageTitle = '理论课程';
        $this->render('/common/table', array(
            'data' => $this->getTheorySubject(),
        ));
    }
}
