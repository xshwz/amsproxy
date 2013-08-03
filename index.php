<?php
session_start();
error_reporting(0);
include 'lib/AmsProxy/AmsProxy.php';
include 'view/header.html';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $amsProxy = new AmsProxy($_POST['uid'], $_POST['pwd']);
        $score = $amsProxy->getScore((bool)$_POST['SJ']);
        include 'view/score.html';
        file_put_contents('student/' . $_POST['uid'], '');
    } catch(Exception $e) {
        $error = '登录失败，可能是学号或密码输入错误。';
        include 'view/login.html';
    }
} else {
    include 'view/login.html';
}
include 'view/footer.html';
