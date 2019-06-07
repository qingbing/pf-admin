<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-06-07
 * Version      :   1.0
 */

namespace Admin\Abstracts;

use Abstracts\Base;

abstract class AfterLogin extends Base
{
    /* @var \Admin\Components\WebUser */
    private $_webUser;

    /**
     * AfterLogin constructor.
     * @param \Admin\Components\WebUser $webUser
     */
    public function __construct($webUser)
    {
        $this->_webUser = $webUser;
    }

    /**
     * 获取当前的用户组件
     * @return \Admin\Components\WebUser
     */
    public function getWebUser()
    {
        return $this->_webUser;
    }

    /**
     * 实例化并属性赋值后执行的二重初始化操作
     *
     * @return mixed
     */
    abstract public function init();
}