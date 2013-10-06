<?php
/**
 * 个人控制器
 */
class PersonalController extends StudentController {
	public function actionArchives() {
    $this->pageTitle = '学籍档案';
		$this->render('archives');
	}
}
