<?php
class ScoreController extends ProxyController {
    public function actionOriginalScore() {
        $this->pageTitle = '原始成绩';
        $scoreTable = $this->get('score');
        $scoreTable = $scoreTable[0];

        if (isset($scoreTable->tbody) && $scoreTable->tbody) {
            $this->addScoreState($scoreTable, 10);
            $this->render('table', array(
                'data' => $scoreTable,
            ));
        } else {
            $this->warning('暂无数据');
        }
    }

    public function actionEffectiveScore() {
        $this->pageTitle = '有效成绩';
        $scoreTable = $this->get('score');
        $scoreTable = $scoreTable[1];

        if (isset($scoreTable->tbody) && $scoreTable->tbody) {
            $this->addScoreState($scoreTable, 6);
            $this->render('table', array(
                'data' => $scoreTable,
            ));
        } else {
            $this->warning('暂无数据');
        }
    }

    public function actionStats() {
        $scoreTable = $this->get('score');
        $scoreTable = $scoreTable[1];
        if (isset($scoreTable->tbody) && $scoreTable->tbody) {
            $this->addScoreState($scoreTable, 6);
            $this->render('stats', array(
                'termNames' => $this->getTermNames($scoreTable),
                'termScoreStats' => $this->getTermScoreStats($scoreTable),
                'scoreDict' => $this->getScoreDist($scoreTable),
                'credits' => $this->getCredits($scoreTable),
            ));
        } else {
            $this->warning('暂无数据');
        }
    }

    public function actionTable() {
        $this->render('table', array('scoreTable' => $this->getScore()));
    }

    /**
     * @param array $scoreTable
     * @param array $scoreIndex
     */
    public function addScoreState(&$scoreTable, $scoreIndex) {
        foreach ($scoreTable->tbody as $termName => &$termScore) {
            foreach ($termScore as &$row) {
                if ((float)$row[$scoreIndex] < 60)
                    $row['state'] = false;
                else
                    $row['state'] = true;
            }
        }
    }

    /**
     * 计算各学期通过／挂科数目
     *
     * @param array $scoreTable 成绩表
     * @return array 统计信息
     */
    public function getTermScoreStats($scoreTable) {
        $termCount = 0;
        foreach ($scoreTable->tbody as $termScore) {
            $stats[0][$termCount] = 0;
            $stats[1][$termCount] = 0;

            foreach ($termScore as $row) {
                if ((float)$row[6] < 60)
                    $stats[1][$termCount]++;
                else
                    $stats[0][$termCount]++;
            }

            $termCount++;
        }

        return $stats;
    }

    /**
     * 计算成绩分布情况
     *
     * @param array $scoreTable 成绩表
     * @return array 成绩分布表
     */
    public function getScoreDist($scoreTable) {
        $scoreDict = array();
        foreach ($scoreTable->tbody as $termScore) {
            foreach ($termScore as $row) {
                if ($row[6] >= 90)
                    $index = 0;
                else if ($row[6] >= 80)
                    $index = 1;
                else if ($row[6] >= 70)
                    $index = 2;
                else if ($row[6] >= 60)
                    $index = 3;
                else
                    $index = 4;

                $scoreDict[$index][] = array(
                    preg_replace('/\[.*?\]/', '', $row[0]),
                    $row[6],
                );
            }
        }
        return $scoreDict;
    }

    /**
     * 获取学期名数组
     *
     * @param array $scoreTable 成绩表
     * @return array 学期名数组
     */
    public function getTermNames($scoreTable) {
        $termNames = array_keys((array)$scoreTable->tbody);
        foreach ($termNames as &$termName)
            $termName = str_replace('学年', '学年 ', $termName);
        return $termNames;
    }

    /**
     * 学分统计
     *
     * @param array $scoreTable 成绩表
     * @return array 学分统计表
     */
    public function getCredits($scoreTable) {
        $credits = array();
        $total = 0;

        foreach ($scoreTable->tbody as $term) {
            foreach ($term as $row) {
                $total += $row[7];
                $course = array(
                  'name' => $row[0],
                  'credit' => $row[7],
                );

                if (array_key_exists($row[2], $credits)) {
                    $credits[$row[2]]['count'] += $row[7];
                    $credits[$row[2]]['courses'][] = $course;
                } else {
                  $credits[$row[2]] = array(
                    'count' => $row[7],
                    'courses' => array($course),
                  );
                }
            }
        }

        return array('total' => $total, 'credits' => $credits);
    }
}
