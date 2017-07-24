<?php
class CourseController extends ProxyController {
    public function actionTable() {
        $this->render('table', array('courses' => $this->get('course')));
    }

    public function actionTableImg() {
        $this->fileField = 'classSchedule';

        // $img = 'data:image/*;base64,'.base64_encode($this->get('classSchedule','fileFields'));
        $src = $this->webUrl('classSchedule');
        // if(isset($_GET['refreshed'])){
            $src = $src.'?t='.time();
        // }

        if(!$this->checkCache_fileFields('classSchedule')){
            $this->update_fileFields('classSchedule');
        }
        $this->render('tableImg', array('src' => $src));
    }

    public function actionToday() {
        $this->render('today', array('courses' => $this->get('course')));
    }

    public function actionTheorySubject() {
        $this->pageTitle = '理论课程';
        $this->field = 'theory_subject';

        $table = $this->get('theory_subject');
        if($table == null){
            $this->update_fields('theory_subject');
            $table = $this->get('theory_subject');
        }
        $this->render('/common/table', array(
            'data' => $this->get('theory_subject'),
        ));
    }
}
