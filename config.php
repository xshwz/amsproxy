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
        'site' => array(
            'defaultController' => 'home',
        ),
    ),
    'defaultController' => 'site',
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
        /* I don't know why it's not work :(
        'urlManager' => array(
            'rules' => array(
                'about' => 'site/home/about',
                'FAQ' => 'site/home/FAQ',
            ),
        ),
        */
    ),
);
