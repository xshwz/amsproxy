<?php
class RefreshController extends StudentController {
    public function actionIndex() {
        $this->student->course = null;
        $this->student->score = null;
        $this->student->rankExam = null;
        $this->student->theorySubject = null;
        $this->student->save();
        $this->render('index');
    }
}
