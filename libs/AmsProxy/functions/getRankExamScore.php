<?php
/**
 * 获取等级考试成绩
 */
class getRankExamScore extends __base__ {
    public function getData() {
        return $this->amsProxy->GET('xscj/Stu_djkscj_rpt.aspx');
    }

    public function parse($dom) {
        $score = array(
            'thead' => array(
                '等级',
                '考试年月',
                '理论成绩',
                '操作成绩',
                '综合成绩',
            ),
        );

        $tables = $dom->getElementsByTagName('table');
        for ($i = 0; $i < $tables->length; $i+=3) {
            $examType = $tables->item($i)
                ->getElementsByTagName('td')
                ->item(0)->textContent;

            $trs = $tables->item($i + 2)->getElementsByTagName('tr');
            foreach ($trs as $tr ) {
                $tds = $tr->getElementsByTagName('td');

                $score['tbody'][$examType][] = array(
                    $tds->item(0)->textContent,
                    $tds->item(1)->textContent,
                    $tds->item(2)->textContent,
                    $tds->item(3)->textContent,
                    $tds->item(4)->textContent,
                );
            }
        }

        return $score;
    }
}
