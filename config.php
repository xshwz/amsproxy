<?php
return array(
    'basePath' => '..',
    'modules' => array(
        'admin' => array(
            'defaultController' => 'home',
        ),
        'proxy' => array(
            'defaultController' => 'home',
        ),
        'site',
    ),
    'defaultController' => 'site/home',
    'import' => array(
        'ext.controllers.*',
        'application.libs.AmsProxy.AmsProxy',
        'application.libs.Mcrypt',
        'application.models.*',
    ),
    'components' => array(
        'db' => array(
            'connectionString' => 'sqlite:../data/amsProxy.db',
        ),
        'viewRenderer' => array(
            'class' => 'CPradoViewRenderer',
            'fileExtension' => '.tpl',
        ),
    ),
);
