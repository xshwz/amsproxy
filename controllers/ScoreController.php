<?php
class ScoreController extends StudentController {
    public $layout = '/score/layout';

    public function actionOriginalScore() {
        $scoreTable = $this->amsProxy->getScore(0);
        $this->addScoreState($scoreTable, 10);
        $this->render('scoreTable', array(
            'score' => $scoreTable,
        ));
    }

    public function actionEffectiveScore() {
        $scoreTable = $this->amsProxy->getScore(1);
        $this->addScoreState($scoreTable, 6);
        $this->render('scoreTable', array(
            'score' => $scoreTable,
        ));
    }

	public function actionStats() {
        $scoreTable = $this->amsProxy->getScore(1);
        $this->addScoreState($scoreTable, 6);
        $this->render('stats', array(
            'termNames' => array_keys($scoreTable['tbody']),
            'termScoreStats' => $this->getTermScoreStats($scoreTable),
        ));
	}

    public function addScoreState(&$scoreTable, $score_index) {
        foreach ($scoreTable['tbody'] as $term_name => &$term_score) {
            foreach ($term_score as &$row) {
                if ((float)$row[$score_index] < 60) $row['state'] = false;
                else $row['state'] = true;
            }
        }
    }

    public function getTermScoreStats($scoreTable) {
        $term_count = 0;
        foreach ($scoreTable['tbody'] as $term_score) {
            $stats[0][$term_count] = 0;
            $stats[1][$term_count] = 0;
            foreach ($term_score as $row) {
                if ((float)$row[6] < 60)
                    $stats[1][$term_count]++;
                else
                    $stats[0][$term_count]++;
            }
            $term_count++;
        }
        return $stats;
    }

    public function getScoreDist($scoreTable) {
        foreach ($scoreTable['tbody'] as $term_score) {
            foreach ($term_score as $row) {
                $score = $row[6];
                if ($row[6] > 90) {
                    ;
                }
            }
        }
    }
}
