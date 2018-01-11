<?php
/**
 * 获取成绩
 *
 * @param bool is effective
 */
class getValidScoreImg extends __base__ {
    public function getData() {
        $domStr = $this->amsProxy->POST(
            'xscj/Stu_MyScore_rpt.aspx',
            array(
                'SJ'=>(int)$this->args,
                'sel_xn'=>$this->lastXN(),
                'sel_xq'=>$this->lastXQ(),
                'btn_search'=>'%BC%EC%CB%F7',
                'SelXNXQ'=>'2',//0入学以来1学年2学期
                'zfx_flag'=>'0',
                'zxf'=>'0'
            )
        );//还是要发一下请求的
        //链接还是直接提取出来好了
        preg_match('/src=\'([^\']*)\'/',$domStr,$match);
        // return $this->amsProxy->GETRaw(
        //     'xscj/Stu_MyScore_Drawimg.aspx',
        //     array(
        //         'x'=>'1',
        //         'h'=>'2',
        //         'w'=>'670',
        //         'xnxq'=>$this->lastXN().$this->lastXQ(),
        //         'xn'=>$this->lastXN(),
        //         'xq'=>$this->lastXQ(),
        //         'rpt'=>'1',
        //         'rad'=>'2',
        //         'zfx'=>'0',
        //     )
        // );
        if(isset($match[1]))
            return $this->amsProxy->GETRaw('xscj/'.$match[1],array());
        else
            return file_get_contents(dirname(__FILE__).'/noneScore.jpg');

    }

    public function parse($dom,$raw) {
        return $raw;
    }
}