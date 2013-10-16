<?php
include 'cUrl/Request.php';

$http = new curl\Request;
echo $http->Request(array(
    'method' => 'post',
    'url' => 'http://ams.gxun.edu.cn/_data/Index_LOGIN.aspx',
    'data' => array(
        'Sel_Type' => 'STU',
        'UserID' => '110263100136',
        'PassWord' => '049659',
    ),
));
echo $http->request(array(
    'url' => 'http://ams.gxun.edu.cn/xsxj/Stu_MyInfo_RPT.aspx',
));
