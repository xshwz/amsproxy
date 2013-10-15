<?php
/**
 * 获取实践环节
 */
class getTheorySubject extends __base__ {
    public function getData() {
        return $this->amsProxy->GET('jxjh/Stu_byfahj_rpt.aspx');
    }

    public function parse($dom) {
        $subject = array(
            'thead' => array(
                '环节',
                '学分',
                '环节类别',
                '考核方式',
                '周数',
            ),
        );

        $tables = $dom->getElementsByTagName('table');
        foreach ($tables->item(2)->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');

            if ($_termName = trim($tds->item(1)->textContent))
                $termName = $_termName;

            $subject['tbody'][$termName][] = array(
                $tds->item(2)->textContent,
                $tds->item(3)->textContent,
                $tds->item(4)->textContent,
                $tds->item(5)->textContent,
                $tds->item(6)->textContent,
            );
        }

        return $subject;
    }
}
