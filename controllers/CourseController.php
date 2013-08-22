<?php
class CourseController extends StudentController {
	public function actionIndex() {
        $courseTable = $this->amsProxy->getCourse();
        $this->render('index', array(
            'courseTable' => $courseTable,
        ));
	}
}
