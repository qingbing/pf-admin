<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-02-24
 * Version      :   1.0
 */
return [
    'class' => '\Admin\Module',
    'layout' => '/layouts/main',
    'preLoad' => ['session'],
    'components' => [
        'user' => [
            'class' => '\Admin\Components\WebUser',
            'cookieKey' => 'admin.user.username',
            'rememberTime' => 864000,
            'namespace' => 'admin.user',
            'expire' => 20,
            'prefix' => 'admin.user_',
            'loginUrl' => ['admin/login/index'],
            'returnUrl' => ['admin/default/index'],
        ],
    ],
];