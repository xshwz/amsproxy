<?php
class AdminerController extends AdminController {
    public function init() {
        parent::init();

        if (!$this->isSuperAdmin()) {
            $this->renderPartial('/common/isNotAdmin');
            Yii::app()->end();
        }
    }

    public function actionIndex() {
        $this->render('index', array(
            'adminers' => Student::model()->findAll(
                'is_admin=:is_admin',
                array(
                    ':is_admin' => 1,
                )
            ),
        ));
    }

    public function actionAdd() {
        $student = Student::model()->findByPk($_POST['sid']);
        $student->is_admin = 1;
        $student->save();
        $this->redirect('index');
    }

    public function actionRemove() {
        if (!$this->isSuperAdmin($_POST['sid'])) {
            $student = Student::model()->findByPk($_POST['sid']);
            $student->is_admin = 0;
            $student->save();
        }

        $this->redirect('index');
    }
}
