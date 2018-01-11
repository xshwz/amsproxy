<?php
class getGraduateRequirement extends __base__ {
    public function getData() {
        return $this->amsProxy->GET(
            'jxjh/Stu_byxfyq_rpt.aspx'
        );
    }

    public function parse($dom,$raw) {
        $tables = $dom->getElementsByTagName('table');
        $score = array(
            'thead'=>array(),
            'tbody'=>array(
                '毕业学分要求' => array()
            )
        );

        foreach ($dom->getElementsByTagName('font') as $font) {
            if($font->textContent == '无相关数据！')
                return array();
        }

        $desscription = $tables->item(0)->getElementsByTagName('td')->item(0)->textContent;

        $table = $tables->item(1);
        
        foreach ($table->getElementsByTagName('tr') as $num => $tr) {
            $tds = $tr->getElementsByTagName('td');

            if($num == 0)
                $score['thead'] = array(
                    trim($tds->item(1)->textContent),
                    trim($tds->item(2)->textContent)
                );
            elseif($num == 1 || $num == 5)
                $score['tbody']['毕业学分要求'][] = array(
                    trim($tds->item(1)->textContent),
                    trim($tds->item(2)->textContent)
                );
            else
                $score['tbody']['毕业学分要求'][] = array(
                    trim($tds->item(0)->textContent),
                    trim($tds->item(1)->textContent)
                );
        }
        
        return array(
            'description' => $desscription,
            'score' => $score
        );
    }
  
}
