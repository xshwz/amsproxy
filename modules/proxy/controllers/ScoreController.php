<?php

class ScoreController extends ProxyController {

    public function actionAffirmScore() {
        $this->pageTitle = '认定成绩';
        $scoreTable = $this->get('scoreAffirm');

        $this->field = 'scoreAffirm';

        if($scoreTable == null){
            $this->update_fields('scoreAffirm');
            $scoreTable = $this->get('scoreAffirm');
        }

        if (isset($scoreTable->tbody) && $scoreTable->tbody) {
            $this->addScoreState($scoreTable, 2);
            $this->render('table', array(
                'data' => $scoreTable,
            ));
        } else {
            $this->warning('暂无数据, 点击右上角[刷新]获取最新数据~');
        }
    }

    public function actionGPA() {
        $this->pageTitle = '绩点统计';
        $GPATable = $this->get('GPA');

        $this->field = 'GPA';

        if($GPATable == null){
            $this->update_fields('GPA');
            $GPATable = $this->get('GPA');
        }

        if (isset($GPATable->tbody) && $GPATable->tbody)
            $this->render('GPA', array(
                'data' => $GPATable,
            ));
        else 
            $this->warning('暂无数据, 点击右上角[刷新]获取最新数据~');
    }

    public function actionValidScore() {
        $this->pageTitle = '有效成绩';
        $scoreTable = $this->get('validScore');
        $scoreImg = $this->get('validScoreImg','fileFields');
        // $img = 'data:image/*;base64,'.base64_encode($scoreImg);

        $src = $this->webUrl('validScoreImg');
        // if(isset($_GET['refreshed'])){
            $src = $src.'?t='.time();
        // }

        $this->field = 'validScore';
        $this->fileField = 'validScoreImg';
        if($scoreTable == null){
            $this->update_fields('validScore');
            $this->update_fileFields('validScoreImg');
            $scoreTable = $this->get('validScore');
        }

        $this->render('validScore', array(
            'src' => $src,
            'data' => $scoreTable,
        ));
    }

    public function actionStats() {
        $this->pageTitle = '原始成绩';
        // $scoreTable = $this->get('score','fileFields');//走缓存
        // $scoreTable = $this->get_score();//不走缓存

        $this->fileField = 'score';
        
        // $img = 'data:image/*;base64,'.base64_encode($scoreTable);
        $src = $this->webUrl('score');
        // if(isset($_GET['refreshed'])){
            $src = $src.'?t='.time();
        // }

        $scoreMinorSrc = file_exists($this->cacheUrl('scoreMinor')) ?
            file_get_contents($this->cacheUrl('scoreMinor')) : '';

        if(strlen($scoreMinorSrc) > 0){
            $this->render('score', array(
                'src' => $src,
                'lastXN' => $this->lastXN(),
                'lastXQ' => $this->lastXQ(),
                'scoreMinor' => $this->webUrl('scoreMinor').'?t='.time()
            ));
        }else
            $this->render('score', array(
                'src' => $src,
                'lastXN' => $this->lastXN(),
                'lastXQ' => $this->lastXQ()
            ));

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
                // TODO 找出中文字面上的挂科成绩
                if (is_numeric($row[$scoreIndex]) && (float)$row[$scoreIndex] < 60)
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
                if (is_numeric($row[6]) && (float)$row[6] < 60)
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
