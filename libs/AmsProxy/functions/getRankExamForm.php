<?php
/**
 * 获取等级考试报名表
 */
class getRankExamForm extends __base__ {
    public function getData() {
        return $this->amsProxy->GET('xscj/Stu_djksbm_rpt.aspx');
    }

    public function parse($dom) {
        $exam = array(
            'thead' => array(
                '等级',
                '构成',
                '考试年月',
                '收费标准（元）',
                '报名时间区段',
                '限定名额',
                '剩余名额',
                '状态',
                '操作',
            ),
        );

        $tables = $dom->getElementsByTagName('table');

        if ($tables->length == 4) {
            foreach ($tables->item(3)->getElementsByTagName('tr') as $tr) {
                $tds = $tr->getElementsByTagName('td');

                if ($_typeName = trim($tds->item(1)->textContent))
                    $typeName = $_typeName;

                $exam['tbody'][$typeName][] = array(
                    $tds->item(2)->textContent,
                    $tds->item(3)->textContent,
                    $tds->item(4)->textContent,
                    $tds->item(5)->textContent,
                    $tds->item(6)->textContent . ' - '
                        . $tds->item(7)->textContent,
                    $tds->item(10)->textContent,
                    $tds->item(11)->textContent,
                    $tds->item(8)->textContent,
                    $tds->item(9)->textContent,

                    'id' => $tds->item(9)->getAttribute('id'),
                );
            }
        }

        return $exam;
    }
}
