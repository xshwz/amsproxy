<?php
class ScoreController extends StudentController {
    public $layout = '/score/layout';

	public function actionIndex() {
        $this->render('index', array(
            'score' => array('Hi'),
        ));
	}

    public function actionOriginalScore() {
        $this->render('scoreTable', array(
            'score' => $this->amsProxy->getScore(0),
        ));
    }

    public function actionEffectiveScore() {
        $this->render('scoreTable', array(
            'score' => $this->amsProxy->getScore(1),
        ));
    }

	public function actionStats() {
        $this->render('stats');
	}
}
