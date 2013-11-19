<?php
/**
 * 等级考试 报名/取消
 *
 * @param string id
 */
class rankExamApply extends __base__ {
    public function getData() {
        return $this->amsProxy->GET('xscj/Stu_djksbm_rpt.aspx');
    }

    public function parse($dom) {
        $node = $dom->getElementById($this->args);
        $data = array(
            'state'   => iconv('utf-8', 'gb18030',
                            $node->getAttribute('value')),
            'lb'      => $node->getAttribute('lb'),
            'dj'      => $node->getAttribute('dj'),
            'year'    => $node->getAttribute('year'),
            'month'   => $node->getAttribute('month'),
            'llbm'    => $node->getAttribute('llbm'),
            'czbm'    => $node->getAttribute('czbm'),
            'chkLLbm' => 1,
            'djmc'    => $node->getAttribute('DJMC'),
        );

        return $this->amsProxy->post('xscj/Stu_djksbm_rpt.aspx', $data);
    }
}
