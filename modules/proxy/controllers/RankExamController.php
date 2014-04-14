<?php
class RankExamController extends ProxyController {
    public function actionForm() {
        $this->pageTitle = '等级考试报名';
        $rankExamForm = $this->AmsProxy()->invoke('getRankExamForm');

        if (isset($rankExamForm->tbody)) {
            foreach ($rankExamForm->tbody as &$tbody) {
                foreach ($tbody as &$trs) {
                    if ($trs->data[8]) {
                        $trs->data[8] = CHtml::link(
                            $trs->data[8],
                            array(
                                'apply',
                                'id' => $trs->id,
                            )
                        );
                    }

                    $trs = $trs->data;
                }
            }

            $this->render('/common/table', array(
                'data' => $rankExamForm,
                'isCollapse' => false,
            ));
        } else {
            $this->warning('暂无数据');
        }
    }

    public function actionScore() {
        $this->pageTitle = '等级考试成绩';
        $rankExam = $this->get('rank_exam');

        if (isset($rankExam->score->tbody)) {
            $this->render('/common/table', array(
                'data' => $rankExam->score,
                'isCollapse' => false,
            ));
        } else {
            $this->warning('暂无数据');
        }
    }

    public function actionApply() {
        $this->AmsProxy()->invoke('rankExamApply', $_GET->id);
        $this->redirect(array('form'));
    }
}
