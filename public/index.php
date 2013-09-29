<?php
session_start();
define('YII_DEBUG', true);
include '../libs/functions.php';
include '../libs/yii/yii.php';
Yii::createWebApplication(include '../config.php')->run();
