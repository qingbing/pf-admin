<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Widgets;


use Abstracts\OutputCache;
use Admin\Components\NavSetting;

class Nav extends OutputCache
{
    /* @var string nav标记 */
    public $navFlag;

    /**
     * 在 @link init() 之前运行
     * @return string|array|mixed
     */
    protected function generateId()
    {
        return [
            'admin.widgets.nav',
            $this->navFlag,
        ];
    }

    /**
     * 构建 cache-content ： 在 @link init() 之后运行
     * @return mixed|void
     * @throws \Exception
     */
    protected function generateContent()
    {
        $this->render('nav', [
            'navFlag' => $this->navFlag,
            'navs' => NavSetting::getInstance()->getNavs(),
        ]);
    }
}