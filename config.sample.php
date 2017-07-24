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
        'wechat',
    ),
    'defaultController' => 'site',
    'import' => array(
        'ext.controllers.*',
        'application.libs.AmsProxy.AmsProxy',
        'application.models.*',
    ),
    'components' => array(
        'db' => array(
            // 'connectionString' => 'sqlite:../data/amsProxy.db',
            'class'=>'CDbConnection',
			'connectionString'=>'',
			'username'=>'',
			'password'=>'',
			'emulatePrepare'=>true,  
        ),
        'viewRenderer' => array(
            'class' => 'ext.view.CPradoViewRenderer',
            'fileExtension' => '.tpl',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                ''       => 'proxy/',
                // ''       => 'site/home/index',
                'about'  => 'site/home/about',
                'faq'    => 'site/home/faq',
                'wechat' => 'site/wechat/index',

                'proxy/login'  => 'proxy/home/login',

                'api'          => 'site/home/api',
                'api/vcode'    => 'site/api/vcode',
                'api/login'    => 'site/api/login',
                'api/logout'   => 'site/api/logout',
                'api/courses'  => 'proxy/api/courses',
                'api/scores'   => 'proxy/api/scores',
                'api/rankExam' => 'proxy/api/rankExam',
                'api/archives' => 'proxy/api/archives',
                'api/exam'     => 'proxy/api/exam',
            ),
        ),
    ),
    'params' => array(
        'debug' => true,
        'curl_debug' => true,
        'useCaptcha'=>true,
        'baseUrl' => '',
        'schoolcode' => '10577',
        'superAdmin' => array(
            '110263100136',
            '111253050122',
            '1514080902121'
        ),
    ),
);
