<?php
/**
 * 获取成绩
 *
 * @param bool is effective
 */
class getScore extends __base__ {
    public function getData() {
        //默认是获取上一年的吧
        $domStr = $this->amsProxy->POST(
            'xscj/Stu_MyScore_rpt.aspx',
            array(
                'SJ'=>(int)$this->args,
                'sel_xn'=>$this->lastXN(),
                'sel_xq'=>$this->lastXQ(),
                'btn_search'=>'%BC%EC%CB%F7',
                'SelXNXQ'=>'2',//0入学以来1学年2学期
                'zfx_flag'=>'0',//0主修 1辅修
                'zxf'=>'0'
            )
        );//还是要发一下请求的

        preg_match('/src=\'([^\']*)\'/',$domStr,$match);
        if(isset($match[1]))
            return $this->amsProxy->GETRaw(
                'xscj/'.$match[1],
                array(
                    // 'x'=>'1',
                    // 'h'=>'2',
                    // 'w'=>'782',
                    // 'xnxq'=>$this->lastXN().$this->lastXQ(),
                    // 'xn'=>$this->lastXN(),
                    // 'xq'=>$this->lastXQ(),
                    // 'rpt'=>'0',
                    // 'rad'=>'2',
                    // 'zfx'=>'0',
                )
            );
        else
            return file_get_contents(dirname(__FILE__).'/noneScore.jpg');
        
    }

    public function parse($dom,$raw) {
        return $raw;
    }
    // public function getData() {
    //     return $this->amsProxy->POST(
    //         'xscj/Stu_MyScore_rpt.aspx',
    //         array(
    //             'SJ'=>(int)$this->args,
    //             'sel_xn'=>$this->getXN(),
    //             'sel_xq'=>$this->getXQ(),
    //             'btn_search'=>'%BC%EC%CB%F7',
    //             'SelXNXQ'=>'2',//0入学以来1学年2学期
    //             'zfx_flag'=>'0',
    //             'zxf'=>'0'
    //         )
    //     );
    // }

    // public function parse($dom) {
    //     if ($this->args)
    //         return $this->parseEffectiveScore($dom);
    //     else
    //         return $this->parseOriginalScore($dom);
    // }

    // /**
    //  * @param DOMDocument $dom
    //  * @return array
    //  */
    // public function parseEffectiveScore($dom) {
    //     $score = array(
    //         'thead' => array(
    //             '课程/环节',
    //             '学分',
    //             '类别',
    //             '课程类别',
    //             '考核方式',
    //             '修读性质',
    //             '成绩',
    //             '取得学分',
    //             '绩点',
    //             '学分绩点',
    //         ),
    //         'tbody' => array(),
    //     );

    //     $tables = $dom->getElementsByTagName('table');
    //     if ($tables->length) {
    //         foreach ($tables->item(2)->getElementsByTagName('tr') as $tr) {
    //             $tds = $tr->getElementsByTagName('td');

    //             if ($term_name = trim($tds->item(0)->textContent))
    //                 $termName = $term_name;

    //             $score['tbody'][$termName][] = array(
    //                 preg_replace('/\[.*?\]/', '',
    //                     $tds->item(1)->textContent),
    //                 $tds->item(2)->textContent,
    //                 $tds->item(3)->textContent,
    //                 $tds->item(4)->textContent,
    //                 $tds->item(5)->textContent,
    //                 $tds->item(6)->textContent,
    //                 $tds->item(7)->textContent,
    //                 $tds->item(8)->textContent,
    //                 $tds->item(9)->textContent,
    //                 $tds->item(10)->textContent,
    //             );
    //         }
    //     }

    //     return $score;
    // }

    // /**
    //  * @param DOMDocument $dom
    //  * @return array
    //  */
    // public function parseOriginalScore($dom) {
    //     $score = array(
    //         'thead' => array(
    //             '课程/环节',
    //             '学分',
    //             '类别',
    //             '课程类别',
    //             '考核方式',
    //             '修读性质',
    //             '平时',
    //             '中考',
    //             '末考',
    //             '技能',
    //             '综合',
    //         ),
    //     );

    //     $tables = $dom->getElementsByTagName('table');
    //     for ($i = 1; $i < $tables->length; $i += 3) {
    //         $termName = $tables
    //             ->item($i)
    //             ->getElementsByTagName('td')
    //             ->item(0)
    //             ->textContent;
    //         $termName = substr($termName, 15);
    //         $termScore = $tables->item($i + 2);

    //         foreach ($termScore->getElementsByTagName('tr') as $tr) {
    //             $tds = $tr->getElementsByTagName('td');
    //             $score['tbody'][$termName][] = array(
    //                 preg_replace('/\[.*?\]/', '',
    //                     $tds->item(1)->textContent),
    //                 $tds->item(2)->textContent,
    //                 $tds->item(3)->textContent,
    //                 $tds->item(4)->textContent,
    //                 $tds->item(5)->textContent,
    //                 $tds->item(6)->textContent,
    //                 $tds->item(7)->textContent,
    //                 $tds->item(8)->textContent,
    //                 $tds->item(9)->textContent,
    //                 $tds->item(10)->textContent,
    //                 $tds->item(11)->textContent,
    //             );
    //         }
    //     }

    //     return $score;
    // }
}
