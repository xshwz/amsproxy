<?php
/**
 * 设置个人信息
 *
 * @param array student info
 */
class setStudentInfo extends __base__ {
    public function run() {
        $data = array(
            'vName0' => 'lxdh',
            'vName1' => 'cym',
            'vName2' => 'jg_id',
            'vName3' => 'lxdz',
            'vName4' => 'sjr',
            'vName5' => 'yzbm',
            'vName6' => 'zzmm_id',
            'vName7' => 'mobilephone',
            'vNU'    => '8',
            'txt0'   => '',
            'txt1'   => '',
            'txt2'   => '',
            'txt3'   => '',
            'txt4'   => '',
            'txt5'   => '',
            'txt6'   => '',
            'txt7'   => '',
        );

        foreach ($this->args as $key => $val)
            $data[$key] = iconv('utf-8', 'gb18030', $val);

        return $this->amsProxy->POST('xsxj/Stu_EditMyInfo_rpt.aspx', $data);
    }
}
