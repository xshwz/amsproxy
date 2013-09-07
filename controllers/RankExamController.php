<?php
class RankExamController extends StudentController {
    public $layout = '/rankExam/layout';

    public function actionIndex() {
        $rankExam = $this->getRankExam(0);
        foreach ( $rankExam['tbody'] as &$tbody ) {
            foreach ( $tbody as &$trs ) {
                if ($trs[8] != '') {
                    $trs[8] = CHtml::link($trs[8], array(
                        'signExam',
                        'rank_id' => $trs['rank_id'],
                    ));
                }
            }
        }
        $this->render('table', array(
            'data' => $rankExam
        ));
    }

    public function actionScore() {
        $this->render('table', array(
            'data' => $this->getRankExam(1),
        ));
    }

    public function actionSignExam() {
        $this->getAmsProxy()->enterRankExam($_GET['rank_id']);
        $this->student->rankExam = null;
        $this->student->save();
        $this->redirect(array('index'));
    }
}
