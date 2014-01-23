<?php
/**
 * 获取学籍档案
 */
class getArchivesEx extends __base__ {
    public function getData() {
        return $this->amsProxy->GET('xscj/Stu_djksbm_rpt.aspx');
    }

    public function parse($dom) {
        $tables = $dom->getElementsByTagName('table');

        if ($tables->length == 4) {
            foreach ($tables->item(1)->getElementsByTagName('tr') as $tr) {
                $tds = $tr->getElementsByTagName('td');

                for ($i = 1; $i < $tds->length; $i += 2) {
                    $key = $this->strip($tds->item($i - 1)->textContent);
                    $value = $this->strip($tds->item($i)->textContent);

                    if ($value)
                        $archives[$key] = $value;
                }
            }

            return $archives;
        } else {
            return $this->getFromOther();
        }
    }

    public function getFromOther() {
        $trs = $this->createDom(
            $this->amsProxy->GET('xsxj/Stu_xszcxs_rpt.aspx')
        )->getElementsByTagName('tr');

        $tds = $trs->item($trs->length - 1)->getElementsByTagName('td');
        return array(
            '院(系)/部' => $tds->item(2)->textContent,
            '年级/专业' => $tds->item(3)->textContent,
            '行政班级'  => $tds->item(4)->textContent,
        );
    }
}
