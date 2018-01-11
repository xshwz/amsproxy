<?php
date_default_timezone_set('Asia/Shanghai');
session_start();
$config = include '../config.php';
define('YII_DEBUG', $config['params']['debug']);
define('CURL_DEBUG', $config['params']['curl_debug']);
include 'ClassLoader.php';
include '../libs/yii/yii.php';
Yii::createWebApplication($config)->run();
