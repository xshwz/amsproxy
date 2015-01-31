<?php

/**
 * 获取单个学期的成绩认定记录
 */
class getScoreAffirmByTerm extends __base__ {
    public function getData() {
        return $this->amsProxy->POST(
            'xscj/c_ydcjrdjl_rpt.aspx',
            array(
                'sel_xnxq' => $this->args,
                'radCx' => 1,
            )
        );
    }

    public function parse($dom) {
        $tables = $dom->getElementsByTagName('table');
        $score = array();
        if ($tables->length) {
            foreach ($tables->item(1)->getElementsByTagName('tr') as $num => $tr) {
                if ($num === 0) continue;
                $tds = $tr->getElementsByTagName('td');

                $term_name = trim($tds->item(8)->textContent);

                $score[$term_name][] = array(
                    preg_replace('/\[.*?\]/', '',
                    $tds->item(0)->textContent),
                    $tds->item(1)->textContent,
                    $tds->item(2)->textContent,
                    $tds->item(3)->textContent,
                    $tds->item(4)->textContent,
                    $tds->item(5)->textContent,
                    $tds->item(6)->textContent,
                    $tds->item(7)->textContent,
                );
            }
        }
        return $score;
    }
}

/**
 * 获取成绩认定记录
 */
class getScoreAffirm extends __base__ {
    public function getData() {
        $scores = array();

        $start_year = (int) ($this->args . '0');
        $xqxn = (int) $this->getXNXQ();
        $count = 0;
        while ($start_year <= $xqxn) {
            // 从 入学学期读到本学期, 如 20110, 20111, 20120, 20121, 20130
            $getScoreAffirmByTerm = new getScoreAffirmByTerm($this->amsProxy, $start_year);
            $score = $getScoreAffirmByTerm->run();
            foreach ($score as $key => $val) {
                $scores[$key] = $val;
            }
            $start_year += ($start_year % 10 === 1) ? 9 : 1;
            if (++ $count > 8) {
                // 因为毕竟 `开学学年` 是从ams获取的，所以容易导致长循环问题。
                // 另外已经毕业的前辈也只用循环8次.
                break;
            }
        }

        return $scores;
    }

    /**
     * createDom
     * @overwrite
     * @param mixed $arr data
     * @return $arr
     */
    public function createDom($arr) {
        return $arr;
    }

    public function parse($arr) {
        return array(
            'thead' => array(
                '课程/环节',
                '学分',
                '课程类别',
                '修读性质',
                '考核方式',
                '辅修标记',
                '原始成绩',
                '有效成绩',
            ),
            'tbody' => $arr,
        );
    }
}
