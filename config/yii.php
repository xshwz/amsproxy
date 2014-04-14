<?php
return array(
  'basePath' => '..',
  'defaultController' => 'public',
  'modules' => array(
    'public' => array(
      'defaultController' => 'home',
    ),
    'proxy' => array(
      'defaultController' => 'home',
    ),
    'admin' => array(
      'defaultController' => 'home',
    ),
  ),
  'import' => array(
    'ext.controllers.*',
    'application.models.*',
    'application.vendor.sammaye.mongoyii.*',
  ),
  'components' => array(
    'viewRenderer' => array(
      'class' => 'application.vendor.yiiext.twig-renderer.ETwigViewRenderer',
      'twigPathAlias' => 'application.vendor.twig.twig.lib.Twig',
      'globals' => array(
        'html' => 'CHtml',
        'yii' => 'Yii',
      ),
    ),
    'mongodb' => array(
      'class' => 'EMongoClient',
      'server' => 'mongodb://localhost:27017',
      'db' => 'amsproxy',
    ),
    'urlManager' => array(
      'urlFormat' => 'path',
      'showScriptName' => false,
      'rules' => array(
        ''       => 'public/home/index',
        'about'  => 'public/home/about',
        'faq'    => 'public/home/faq',
        'wechat' => 'public/wechat/index',
      ),
    ),
  ),
);
