<?php
/**
 * 课程控制器
 */
class CourseController extends StudentController {
	public function actionIndex() {
        $this->render('index', array('courses' => $this->getCourse()));
	}

    public function actionRefresh() {
        $this->student->course = null;
        $this->student->save();
        $this->render('index', array(
            'courses' => $this->getCourse(),
            'refresh' => 1,
        ));
    }
}
