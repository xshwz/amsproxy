<?php
/**
 * 成绩控制器
 */
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
            'termNames' => $this->getTermNames($scoreTable),
            'termScoreStats' => $this->getTermScoreStats($scoreTable),
            'scoreDict' => $this->getScoreDist($scoreTable),
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

    /**
     * 计算各学期通过／挂科数目
     * @param array $scoreTable 成绩表
     * @return array 统计信息
     */
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

    /**
     * 计算成绩分布情况
     * @param array $scoreTable 成绩表
     * @return array 成绩分布表
     */
    public function getScoreDist($scoreTable) {
        $scoreDict = array(0, 0, 0, 0, 0);
        foreach ($scoreTable['tbody'] as $term_score) {
            foreach ($term_score as $row) {
                if ($row[6] >= 90)
                    $scoreDict[0]++;
                else if ($row[6] >= 80)
                    $scoreDict[1]++;
                else if ($row[6] >= 70)
                    $scoreDict[2]++;
                else if ($row[6] >= 60)
                    $scoreDict[3]++;
                else
                    $scoreDict[4]++;
            }
        }
        return $scoreDict;
    }


    /**
     * 获取学期名数组
     * @param array $scoreTable 成绩表
     * @return array 学期名数组
     */
    public function getTermNames($scoreTable) {
        foreach (array_keys($scoreTable['tbody']) as &$termName) {
            $termNames[] = str_replace('学年', '学年 ', $termName);
        }
        return $termNames;
    }
}
