<?php
class CourseController extends ProxyController {
    public function actionTable() {
        $this->render('table', array('courses' => $this->get('course')));
    }

    public function actionToday() {
        $this->render('today', array('courses' => $this->get('course')));
    }

    public function actionTheorySubject() {
        $this->pageTitle = '理论课程';
        $this->render('/common/table', array(
            'data' => $this->get('theory_subject'),
        ));
    }
}
