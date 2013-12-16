<?php
class CourseController extends BaseController {
    public function actionIndex() {
        $amsProxy = new AmsProxy(array(
            'sid' => '110263100136',
            'pwd' => '049659',
        ));

        print_r($amsProxy->invoke('getCourses', '1'));

        //$this->render('index');
    }
}
