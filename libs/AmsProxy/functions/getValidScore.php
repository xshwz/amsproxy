<?php
/**
 * 获取成绩
 *
 * @param bool is effective
 */
class getValidScore extends __base__ {
    public function getData() {
        return $this->amsProxy->POST(
            'xscj/Stu_MyScore_rpt.aspx',
            array(
                'SJ'=>1,
                'sel_xn'=>$this->lastXN(),
                'sel_xq'=>$this->lastXQ(),
                'btn_search'=>'%BC%EC%CB%F7',
                'SelXNXQ'=>'2',//0入学以来1学年2学期
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
                '成绩统计' => array()
            )
        );
        //主要是部分同学是没有成绩统计的,所以导致抓取错误
        if ($tables->length && $tables->item(3)->getAttribute('bgcolor') == '#89bfa7') {
            foreach ($tables->item(3)->getElementsByTagName('tr') as $num => $tr) {
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
                    $score['tbody']['成绩统计'][] = array(
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