<?php
/**
 * 课程控制器
 */
class CourseController extends StudentController {
	public function actionIndex() {
        $this->render('index', array('courses' => $this->getCourse()));
	}
}
