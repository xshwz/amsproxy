<?php
class RankExamController extends StudentController {
    public function actionForm() {
        $this->pageTitle = '等级考试报名';
        $rankExam = $this->getRankExam();
        if (isset($rankExam['tbody'])) {
            foreach ( $rankExam['form']['tbody'] as &$tbody ) {
                foreach ( $tbody as &$trs ) {
                    if ($trs[8]) {
                        $trs[8] = CHtml::link($trs[8], array(
                            'apply',
                            'id' => $trs['id'],
                        ));
                    }
                }
            }

            $this->render('/common/table', array(
                'data' => $rankExam['form'],
                'type' => 1,
            ));
        } else {
            $this->warning('暂无数据');
        }
    }

    public function actionScore() {
        $this->pageTitle = '等级考试成绩';
        $rankExam = $this->getRankExam();
        if (isset($rankExam['tbody'])) {
            $this->render('/common/table', array(
                'data' => $rankExam['score'],
                'type' => 1,
            ));
        } else {
            $this->warning('暂无数据');
        }
    }

    public function actionApply() {
        $this->AmsProxy()->invoke('rankExamApply', $_GET['id']);
        $this->student->rank_exam = null;
        $this->student->save();
        $this->redirect(array('index'));
    }
}
