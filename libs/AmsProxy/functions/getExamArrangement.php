<?php
/**
 * 获取考试安排
 *
 * @param string term number
 */
class getExamArrangement extends __base__ {
    public function getData() {
        $responseText = $this->amsProxy->GET(
            'KSSW/Private/list_xnxqkslc.aspx');

        if ($this->args == null) {
            preg_match(
                '/option\\s+value=[\'"](\\d+,)/',
                $responseText, $matches);
            if (sizeof($matches) > 0) {
                $this->args = $matches[1];
            }
        }

        return $this->amsProxy->POST(
            'KSSW/stu_ksap_rpt.aspx',
            array(
                'sel_lc' => $this->args,
            )
        );
    }

    public function parse($dom) {
        $exam = array(
            'thead' => array(
                '课程',
                '学分',
                '类别',
                '考核方式',
                '考试时间',
                '考试地点',
                '座位号',
            ),
            'tbody' => array(),
        );

        $tables = $dom->getElementsByTagName('table');
        if ($tables->length) {
            foreach($tables->item(2)->getElementsByTagName('tr') as $tr) {
                $tds = $tr->getElementsByTagName('td');
                $exam['tbody'][] = array(
                    preg_replace('/\[.*?\]/', '',
                        $tds->item(1)->textContent),
                    $tds->item(2)->textContent,
                    $tds->item(3)->textContent,
                    $tds->item(4)->textContent,
                    $tds->item(5)->textContent,
                    $tds->item(6)->textContent,
                    $tds->item(7)->textContent,
                );
            }
        }

        return $exam;
    }
}
