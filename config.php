<?php
return array(
    'basePath' => '..',
    'import' => array(
        'ext.controllers.*',
        'application.libs.AmsProxy.AmsProxy',
    ),
    'components' => array(
        'db' => array(
            'connectionString' => 'sqlite:data/amsProxy.db',
            'tablePrefix' => '',
        ),
    ),
);
