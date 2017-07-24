<?php
/**
 * 获取成绩辅修
 *
 * @param bool is effective
 */
class getScoreMinor extends __base__ {
    public function getData() {
        $domStr = $this->amsProxy->POST(
            'xscj/Stu_MyScore_rpt.aspx',
            array(
                'SJ'=>(int)$this->args,
                'sel_xn'=>$this->lastXN(),
                'sel_xq'=>$this->lastXQ(),
                'btn_search'=>'%BC%EC%CB%F7',
                'SelXNXQ'=>'2',//0入学以来1学年2学期
                'zfx_flag'=>'1',//0主修 1辅修
                'zxf'=>'0'
            )
        );

        preg_match('/src=\'([^\']*)\'/',$domStr,$match);
        if(isset($match[1]))
            return $this->amsProxy->GETRaw(
                'xscj/'.$match[1],
                array()
            );
        else
            return '';
        
    }

    public function parse($dom,$raw) {
        return $raw;
    }
}
