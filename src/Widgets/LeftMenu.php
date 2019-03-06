<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Widgets;


use Abstracts\OutputCache;
use Admin\Components\Pub;

class LeftMenu extends OutputCache
{
    private $_isSuper;

    /**
     * @throws \Helper\Exception
     */
    protected function begin()
    {
        $this->_isSuper = Pub::getUser()->getIsSuper();
        parent::begin();
    }

    /**
     * 在 @link init() 之前运行
     * @return string|array|mixed
     */
    protected function generateId()
    {
        return [
            'admin.widgets.leftMenu.',
            ($this->_isSuper ? 'y' : 'n')
        ];
    }

    /**
     * 构建 cache-content ： 在 @link init() 之后运行
     * @return mixed
     */
    protected function generateContent()
    {
//        $accessMods = U::keyValue('access-mod');
//        $navMods = U::keyValue('nav-mod');
        $this->render('left-menu', [
            'isSuper' => $this->_isSuper,
//            'accessMods' => $accessMods,
//            'navMods' => $navMods,
        ]);
    }
}