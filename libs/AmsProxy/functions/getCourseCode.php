<?php
/**
 * 获取课程代号，以便获取课程课表
 *
 * @param string course name
 */
class getCourseCode extends __base__ {
    public function run() {
        $courseInfo = $this->amsProxy->GET(
            'ZNPK/Private/List_XNXQKC.aspx',
            array(
                'xnxq' => $this->getXNXQ(),
                'kc'   => iconv('utf-8', 'gb18030', $this->args),
            )
        );

        preg_match_all('/option value=(\d+)>(.*?)</', $courseInfo, $matches);
        return isset($matches[0][0]) ? array(
            'code' => $matches[1],
            'name' => preg_replace('/.*\|/', '', $matches[2])) : null;
    }
}
