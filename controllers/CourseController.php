<?php
/**
 * 课程控制器
 */
class CourseController extends StudentController {
	public function actionTable() {
        $this->pageTitle = '课程表';
        $this->render('table', array('courses' => $this->getCourse()));
	}

	public function actionToday() {
        $this->pageTitle = '今日课程';
        $this->render('today', array('courses' => $this->getCourse()));
	}

	public function actionPlan() {
        $this->pageTitle = '教学计划';
        $this->render('plan');
	}
}
