<?php
/**
 * 获取班级代号，以便获取班级课表
 *
 * @param string class name
 */
class getClassCode extends __base__ {
    public function run() {
        $classInfo = $this->amsProxy->GET(
            'ZNPK/Private/List_XZBJ.aspx',
            array(
                'xnxq' => $this->getXNXQ(),
                'xzbj' => iconv('utf-8', 'gb18030', $this->args),
            )
        );

        preg_match_all('/option value=(\d+)>(.*?)</', $classInfo, $matches);
        return isset($matches[0][0]) ? array(
            'code' => $matches[1],
            'name' => $matches[2]) : null;
    }
}
