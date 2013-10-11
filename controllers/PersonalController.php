<?php
/**
 * 个人控制器
 */
class PersonalController extends StudentController {
	public function actionArchives() {
        $this->pageTitle = '学籍档案';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->getAmsProxy()->setStudentInfo($_POST);
            $this->student->archives = json_encode($this->getAmsProxy()->getStudentInfo());
        }

        $this->render('archives', array(
            'archives' => (array)$this->student->getArchives(),
        ));
    }
}
