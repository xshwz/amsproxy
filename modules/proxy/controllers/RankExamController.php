<?php
class RankExamController extends ProxyController {
    public function actionForm() {
        $this->pageTitle = '等级考试报名';

        // $this->commonField = 'rankExamForm';
        // $rankExamForm = $this->get('rankExamForm','commonFields');

        $this->getAuthToUpdate();
        $rankExamForm = $this->get_rankExamForm();

        if (isset($rankExamForm->tbody)) {
            foreach ($rankExamForm->tbody as &$tbody) {
                foreach ($tbody as &$trs) {
                    if ($trs->data[0]) {
                        $trs->data[0] = CHtml::link(
                            $trs->data[0],
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
                'message' => '如果空白,请点击导航栏的刷新图标获取最新数据~~'
            ));
        } else {
            $this->warning('暂无数据');
        }
    }

    public function actionScore() {
        $this->pageTitle = '等级考试成绩';
        $rankExam = $this->get('rank_exam');

        $this->field = 'rank_exam';

        if($rankExam == null){
            $this->update_fields('rank_exam');
            $rankExam = $this->get('rank_exam');
        }

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
        $this->AmsProxy()->invoke('rankExamApply', $_GET['id']);
        $this->redirect(array('form'));
    }
}
