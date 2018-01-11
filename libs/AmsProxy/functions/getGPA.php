<?php
class getGPA extends __base__ {
    public function getData() {
        return $this->amsProxy->POST(
            'xscj/Stu_MyScore_rpt.aspx',
            array(
                'SJ'=>1,
                'btn_search'=>'%BC%EC%CB%F7',
                'SelXNXQ'=>'0',
                'zfx_flag'=>'0',
                'zxf'=>'0'
            )
        );
    }

    public function parse($dom,$raw) {
      $tables = $dom->getElementsByTagName('table');
        $score = array(
            'thead'=>array(),
            'tbody'=>array(
                '入学以来' => array()
            )
        );
        //主要是部分同学是没有成绩统计的,所以导致抓取错误
        foreach($tables as $table) {
          if($table->getAttribute('bgcolor') == '#89bfa7')
            foreach ($table->getElementsByTagName('tr') as $num => $tr) {
                $tds = $tr->getElementsByTagName('td');
                if($num == 0){
                    $score['thead'] = array(
                        trim($tds->item(0)->textContent),
                        trim($tds->item(1)->textContent),
                        trim($tds->item(2)->textContent),
                        trim($tds->item(3)->textContent),
                        trim($tds->item(4)->textContent),
                        trim($tds->item(5)->textContent),
                        trim($tds->item(6)->textContent),
                    );
                }
                else
                    $score['tbody']['入学以来'][] = array(
                        trim($tds->item(0)->textContent),
                        trim($tds->item(1)->textContent),
                        trim($tds->item(2)->textContent),
                        trim($tds->item(3)->textContent),
                        trim($tds->item(4)->textContent),
                        trim($tds->item(5)->textContent),
                        trim($tds->item(6)->textContent),
                    );
            }
        }
        return $score;
    }
  
}
