<?php
session_start();
define('YII_DEBUG', true);
include '../libs/yii/yii.php';
Yii::createWebApplication(include '../config.php')->run();
