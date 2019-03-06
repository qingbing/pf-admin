<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Components;


use Admin\Models\User;

class UserIdentity extends \Abstracts\UserIdentity
{
    /* @var \Admin\Models\User */
    private $_user;

    /**
     * 验证用户登陆
     * @return bool|int
     * @throws \Exception
     */
    public function authenticate()
    {
        if (empty($this->username)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_user = $user = User::model()->findByAttributes([
                'username' => $this->username,
            ]);
            /* @var $user User */
            if (empty($user)) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else if (!$user->is_enable) {
                $this->errorCode = self::ERROR_USER_FORBID;
            } else if ($user->password != $user->generatePassword($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->errorCode = self::ERROR_NONE;
            }
        }
        return $this->errorCode;
    }

    /**
     * 返回组件认证的用户信息
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }
}