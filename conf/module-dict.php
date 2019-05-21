<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-02-24
 * Version      :   1.0
 */
return [
    'class' => '\Dict\Module',
    'username' => 'qingbing',
    'password' => '123456',
    'components' => [
        'user' => [
            'class' => '\Dict\Components\WebUser',
            'cookieKey' => 'dict.user.username',
            'rememberTime' => 864000,
            'namespace' => 'dict.user',
            'expire' => 600,
            'prefix' => 'dict.user_',
            'loginUrl' => ['dict/login/index'],
            'returnUrl' => ['dict/default/index'],
        ],
    ],
];