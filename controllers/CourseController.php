<?php
/**
 * 课程控制器
 */
class CourseController extends StudentController {
	public function actionTable() {
        $this->pageTitle = '课程表';
        $this->render('courseTable', array('courses' => $this->getCourse()));
	}

	public function actionToday() {
        $this->pageTitle = '今日课程';
        $this->render('courseLine', array('courses' => $this->getCourse()));
	}

	public function actionTheorySubject() {
        $this->pageTitle = '理论课程';
        $this->render('/common/table', array(
            'data' => $this->getTheorySubject(),
        ));
	}
}
