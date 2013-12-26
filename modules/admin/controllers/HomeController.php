<?php
class HomeController extends AdminController {
    public function actionIndex() {
        $this->render('index', array(
            'studentCount' => Student::model()->count(
                'last_login_time>:time', array(
                    'time' => date('Y-m-d'),
                )
            ),
        ));
    }
}
