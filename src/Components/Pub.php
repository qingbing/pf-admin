<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Components;


class Pub
{
    /**
     * 获取当前 application
     * @return \Abstracts\Application|\Render\Application
     */
    public static function getApp()
    {
        return \PF::app();
    }

    /**
     * 获取当前 module
     * @return \Abstracts\Module | \Admin\Module
     */
    public static function getModule()
    {
        return self::getApp()->getController()->getModule();
    }

    /**
     * 获取当前模块的用户组件
     * @return \Admin\Components\WebUser|\Abstracts\Component|null
     * @throws \Helper\Exception
     */
    public static function getUser()
    {
        return self::getModule()->getComponent('user');
    }

    /**
     * 验证个人密码是否正确
     * @return bool
     * @throws \Helper\Exception
     */
    static public function validMyPassword()
    {
        $param = self::getApp()->getRequest()->getParam('myPassword');
        if (empty($param)) {
            return false;
        }
        $user = self::getUser()->getUserInfo();
        /* @var \Admin\Models\User $user */
        return $user->comparePassword($param);
    }
}