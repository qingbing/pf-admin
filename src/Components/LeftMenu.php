<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-05-18
 * Version      :   1.0
 */

namespace Admin\Components;


use Abstracts\OutputCache;

abstract class LeftMenu extends OutputCache
{
    /* @var string nav标记 */
    public $navFlag;

    protected $isSuper;

    /**
     * @throws \Helper\Exception
     */
    protected function begin()
    {
        $this->isSuper = Pub::getUser()->getIsSuper();
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
            $this->navFlag,
            ($this->isSuper ? 'y' : 'n'),
        ];
    }
}