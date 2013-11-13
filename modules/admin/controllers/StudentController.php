<?php
class StudentController extends AdminController {
    public function actionIndex() {
        $criteria = new CDbCriteria();

        if (isset($_GET['keyword'])) {
            $criteria->addSearchCondition('archives',
                str_replace('"', '%', json_encode($_GET['keyword'])),
                false);
        }

        $criteria->order = 'last_login_time DESC';

        $count = Student::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = isset($_GET['pages']) ? (int)$_GET['pages'] : 20;
        $pages->applyLimit($criteria);
        $this->render('index', array(
            'students' => Student::model()->findAll($criteria),
            'count' => $count,
            'pages' => $pages,
        ));
    }
}
