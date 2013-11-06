<?php
/**
 * 获取理论课程
 */
class getTheorySubject extends __base__ {
    public function getData() {
        return $this->amsProxy->GET('jxjh/Stu_byfakc_rpt.aspx');
    }

    public function parse($dom) {
        $subject = array(
            'thead' => array(
                '课程',
                '学分',
                '课程类别',
                '考核方式',
                '总学时',
                '讲授学时',
                '实验学时',
                '上机学时',
                '其它学时',
                '周学时',
            ),
        );

        $tables = $dom->getElementsByTagName('table');

        if ($tables->length) {
            foreach ($tables->item(2)->getElementsByTagName('tr') as $tr) {
                $tds = $tr->getElementsByTagName('td');

                if ($_termName = trim($tds->item(1)->textContent))
                    $termName = $_termName;

                $subject['tbody'][$termName][] = array(
                    preg_replace('/\[.*?\]/', '',
                        $tds->item(2)->textContent),
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

        return $subject;
    }
}
