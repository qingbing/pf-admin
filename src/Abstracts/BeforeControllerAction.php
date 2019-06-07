<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-06-07
 * Version      :   1.0
 */

namespace Admin\Abstracts;

use Abstracts\Base;

/**
 * 用户自定义的admin模块进入操作及检测
 *
 * Class BeforeControllerAction
 * @package Admin\Abstracts
 */
abstract class BeforeControllerAction extends Base
{
    private $_controller;
    private $_action;

    /**
     * BeforeControllerAction constructor.
     * @param \Abstracts\BaseController $controller
     * @param \Abstracts\Action $action
     */
    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
    }

    /**
     * 获取当前 controller
     * @return \Abstracts\BaseController
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * 获取当前 action
     * @return \Abstracts\Action
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * 实例化并属性赋值后执行的二重初始化操作
     *
     * @return mixed
     */
    abstract public function init();

    /**
     * 是否向下执行
     * @return bool
     */
    public function run()
    {
        return true;
    }
}