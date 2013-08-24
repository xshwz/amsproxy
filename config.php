<?php
return array(
    'basePath' => '..',
    'import' => array(
        'ext.controllers.*',
        'application.libs.AmsProxy.AmsProxy',
        'application.models.*',
    ),
    'components' => array(
        'db' => array(
            'connectionString' => 'sqlite:../data/amsProxy.db',
            'tablePrefix' => '',
        ),
    ),
);
