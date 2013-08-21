<?php
session_start();
define('YII_DEBUG',true);
require_once('../libs/yii/yii.php');
Yii::createWebApplication(include '../config.php')->run();
