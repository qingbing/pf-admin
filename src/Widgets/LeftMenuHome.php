<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Widgets;


use Admin\Components\Pub;

class LeftMenuHome extends \Admin\Components\LeftMenu
{
    /* @var string nav标记 */
    public $navFlag = 'home';

    /**
     * 构建 cache-content ： 在 @link init() 之后运行
     * @throws \Exception
     */
    protected function generateContent()
    {
        $this->render('left-menu-home', [
            'isSuper' => $this->isSuper,
        ]);
    }
}