<?php
/**
 * 获取成绩
 *
 * @param bool is effective
 */
class getClassSchedule extends __base__ {
    public function getData() {
        $hidyzm = $this->getHidyzm();
        if ($hidyzm !== false) {
            // $m 是一个随机字串, 这里就不随机了.
            $m = 'hDIbFprNaT0AGib';
            $hidsjyzm = strtoupper(md5($this->amsProxy->schoolcode . $this->getXNXQ() . $m));

            $domStr = $this->amsProxy->POST(
                'znpk/Pri_StuSel_rpt.aspx',
                array(
                    'Sel_XNXQ' => $this->getXNXQ(),
                    'rad'      => 0,
                    'px'       => 0,
                    'hidyzm' => $hidyzm,
                    'hidsjyzm' => $hidsjyzm,
                ),
                array(
                    'm' => $m,
                )
            );
            preg_match('/src=\'([^\']*)\'/',$domStr,$match);
            
            if(isset($match[1]))
                return $this->amsProxy->curl->request(
                    array(
                        'method'  => 'get',
                        'url'     => $this->amsProxy->baseUrl . 'znpk/'.$match[1],
                        // 'params'  => array(
                        //         'type'=>'1',
                        //         'w'=>'1100',
                        //         'h'=>'520',
                        //         'xnxq'=>$this->getXNXQ()
                        //     ),
                        'headers' => array(
                            'Referer' => $this->amsProxy->baseUrl . 'znpk/Pri_StuSel_rpt.aspx?m=' . $m,
                        ),
                    )
                )->body;
            else
                return file_get_contents(dirname(__FILE__).'/noneCourse.jpg');
        } else {
            return 'false';
        }
    }

    public function parse($dom,$raw) {
        return $raw;
    }
    public function getHidyzm() {
        $page = $this->htmlFinishing($this->amsProxy->GET('znpk/Pri_StuSel.aspx'));
        preg_match('/input type=\"hidden\" name=\"hidyzm\" value=\"(.+)\"/isU',$page,$match);
        return $match[1];
    }
}
