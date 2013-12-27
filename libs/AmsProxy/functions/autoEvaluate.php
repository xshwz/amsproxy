<?php
/**
 * TODO: 不干了！
 */
class autoEvaluate extends __base__ {
    public function getData() {
        return $this->amsProxy->POST(
            'jxkp/Stu_wskp_rpt.aspx',
            array(
                'sel_lc' => '20130|2013001|1|1',
            )
        );
    }

    public function parse($dom) {
        foreach ($dom->getElementById('ID_Table')
                     ->getElementsByTagName('tr') as $tr) {

            $this->autoSubmit(
                'jxkp/' . substr($this->getAttr(
                    $tr->getElementsByTagName('a')->item(0), 'onclick'),
                    17, -50
                )
            );
            exit();
        }
    }

    public function autoSubmit($link) {
        $inputs = $this->createDom(
            $this->amsProxy->GET($link))->getElementsByTagName('input');

        $txt_count = $this->getValueByName($inputs, 'txtlb');
        $txt_kc    = $this->getValueByName($inputs, 'txtkc');
        $txt_js    = $this->getValueByName($inputs, 'txtjs');

        echo $this->amsProxy->request('post',
            'jxkp/Stu_WSKP_pj.aspx',
            array(
                's'    => $this->getValueByName($inputs, 'txts'),
                'id'   => $this->getValueByName($inputs, 'txtuser'),
                'pjry' => $txt_count,
                'xn'   => $this->getValueByName($inputs, 'txtxn'),
                'xq'   => $this->getValueByName($inputs, 'txtxq'),
                'js'   => $txt_js,
                'kc'   => $txt_kc,
                'kclx' => $this->getValueByName($inputs, 'txtkclx'),
                'lb'   => $txt_count,
                'kclb' => $this->getValueByName($inputs, 'txtkclb'),
            ),
            http_build_query(
                array_merge(
                    $this->createFormData($inputs, (int)$txt_count),
                    array(
                        'txt_count' => $txt_count,
                        'txtkc'     => $txt_kc,
                        'txtjs'     => $txt_js,
                    )
                )
            )
        );
    }

    public function getValueByName($inputs, $name) {
        foreach ($inputs as $input) {
            if ($this->getAttr($input, 'name') == $name)
                return $this->getAttr($input, 'value');
        }
    }

    public function getAttr($node, $attribute) {
        return $node->attributes->getNamedItem($attribute)->textContent;
    }

    public function createFormData($inputs, $n) {
        for ($c = 0; $c < $n; $c++)
            $data['cj' . $c] = $this->getValueByName($inputs, 'cj' . $c);
        return $data;
    }
}
