<?php
/**
 * 获取选课列表
 */
class getElectiveList extends __base__ {
    public function getData() {
        $this->getCoursesUrl();
        exit();
    }

    public function parse($dom) {
        //return $electives;
    }

    public function getCoursesUrl() {
        $html = $this->amsProxy->POST('wsxk/stu_xszx_rpt.aspx', array(
            'sel_lx'        => '0',
            'SelSpeciality' => $this->getSpeciality(),
            'Submit'        => iconv('utf-8', 'gb18030', '检索'),
        ));

        $dom = $this->createDom($html);
        $trs = $dom->getElementById('oTable')->getElementsByTagName('tr');

        for ($i = 1; $i < $trs->length - 1; $i++) {
            $id = $this->getValue(
                $trs->item($i)
                    ->getElementsByTagName('td')->item(6)
                    ->getElementsByTagName('a')->item(0)
            );
            $skbjval = $this->getValue(
                $dom->getElementById('chkSKBJ' . ($i - 1)));

            $urls[] =
                'stu_xszx_chooseskbj.aspx?lx=ZX&id=' . id .
                '&skbjval=' . $skbjval . '&xq=%';
        }

        print_r($urls);
    }

    public function getSpeciality() {
        preg_match(
            '/option value=(\d+) selected/',
            $this->amsProxy->GET('WSXK/Private/List_WSXK_NJZY.aspx'),
            $matches);
        return $matches[1];
    }

    public function getValue($node) {
        return $node->attributes->getNamedItem('value')->textContent;
    }
}
