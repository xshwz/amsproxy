<?php
session_start();
$config = include '../config.php';
define('YII_DEBUG', $config['params']['debug']);
include 'ClassLoader.php';
include '../libs/yii/yii.php';
Yii::createWebApplication($config)->run();
