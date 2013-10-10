<?php
/**
 * 个人控制器
 */
class PersonalController extends StudentController {
	public function actionArchives() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->getAmsProxy()->setStudentInfo($_POST);
            $this->student->info = json_encode($this->getAmsProxy()->getStudentInfo());
        }
        $this->pageTitle = '学籍档案';
        $this->render('archives');
    }
}
