<?php
session_start();
define('YII_DEBUG', true);
include 'ClassLoader.php';
include '../libs/yii/yii.php';
Yii::createWebApplication(include '../config.php')->run();
