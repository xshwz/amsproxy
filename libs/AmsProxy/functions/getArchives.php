<?php
/**
 * 获取学籍档案
 */
class getArchives extends __base__ {
    public function getData() {
        return $this->amsProxy->GET('xsxj/Stu_MyInfo_RPT.aspx');
    }

    public function parse($dom) {
        $table = $dom->getElementsByTagName('table')->item(0);

        foreach ($table->getElementsByTagName('tr') as $tr) {
            $tds = $tr->getElementsByTagName('td');

            for ($i = 1; $i < $tds->length; $i += 2) {
                $key = $this->strip($tds->item($i - 1)->textContent);
                $value = $this->strip($tds->item($i)->textContent);

                if ($value)
                    $archives[$key] = $value;
            }
        }

        return $archives;
    }
}
