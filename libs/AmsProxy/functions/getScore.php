<?php
/**
 * 获取成绩
 *
 * @param bool is effective
 */
class getScore extends __base__ {
    // 这个获取方法在广西民大里已经无效
    public function getData() {
        return $this->amsProxy->POST(
            'xscj/Stu_MyScore_rpt.aspx',
            array(
                'SJ'       => (int)$this->args,
                'SelXNXQ'  => 0,
                'txt_xm'   => null,
                'zfx_flag' => 0,
                'zxf'      => 0,
            )
        );
    }

    public function parse($dom) {
        if ($this->args)
            return $this->parseEffectiveScore($dom);
        else
            return $this->parseOriginalScore($dom);
    }

    /**
     * @param DOMDocument $dom
     * @return array
     */
    public function parseEffectiveScore($dom) {
        $score = array(
            'thead' => array(
                '课程/环节',
                '学分',
                '类别',
                '课程类别',
                '考核方式',
                '修读性质',
                '成绩',
                '取得学分',
                '绩点',
                '学分绩点',
            ),
            'tbody' => array(),
        );

        $tables = $dom->getElementsByTagName('table');
        if ($tables->length) {
            foreach ($tables->item(2)->getElementsByTagName('tr') as $tr) {
                $tds = $tr->getElementsByTagName('td');

                if ($term_name = trim($tds->item(0)->textContent))
                    $termName = $term_name;

                $score['tbody'][$termName][] = array(
                    preg_replace('/\[.*?\]/', '',
                        $tds->item(1)->textContent),
                    $tds->item(2)->textContent,
                    $tds->item(3)->textContent,
                    $tds->item(4)->textContent,
                    $tds->item(5)->textContent,
                    $tds->item(6)->textContent,
                    $tds->item(7)->textContent,
                    $tds->item(8)->textContent,
                    $tds->item(9)->textContent,
                    $tds->item(10)->textContent,
                );
            }
        }

        return $score;
    }

    /**
     * @param DOMDocument $dom
     * @return array
     */
    public function parseOriginalScore($dom) {
        $score = array(
            'thead' => array(
                '课程/环节',
                '学分',
                '类别',
                '课程类别',
                '考核方式',
                '修读性质',
                '平时',
                '中考',
                '末考',
                '技能',
                '综合',
            ),
        );

        $tables = $dom->getElementsByTagName('table');
        for ($i = 1; $i < $tables->length; $i += 3) {
            $termName = $tables
                ->item($i)
                ->getElementsByTagName('td')
                ->item(0)
                ->textContent;
            $termName = substr($termName, 15);
            $termScore = $tables->item($i + 2);

            foreach ($termScore->getElementsByTagName('tr') as $tr) {
                $tds = $tr->getElementsByTagName('td');
                $score['tbody'][$termName][] = array(
                    preg_replace('/\[.*?\]/', '',
                        $tds->item(1)->textContent),
                    $tds->item(2)->textContent,
                    $tds->item(3)->textContent,
                    $tds->item(4)->textContent,
                    $tds->item(5)->textContent,
                    $tds->item(6)->textContent,
                    $tds->item(7)->textContent,
                    $tds->item(8)->textContent,
                    $tds->item(9)->textContent,
                    $tds->item(10)->textContent,
                    $tds->item(11)->textContent,
                );
            }
        }

        return $score;
    }
}
