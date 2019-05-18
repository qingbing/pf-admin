<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Widgets;


use Admin\Components\Pub;

class LeftMenuSetting extends \Admin\Components\LeftMenu
{
    /* @var string nav标记 */
    public $navFlag = 'setting';

    /**
     * 获取网站设置菜单，通过表单配置管理
     * @return array
     * @throws \Exception
     */
    public function getSiteSetting()
    {
        return Pub::getApp()->getDb()->getFindBuilder()
            ->setTable('pub_form_category')
            ->addWhere('`is_setting`=:is_setting AND `is_open`=:is_open AND `is_enable`=:is_enable')
            ->addParam(':is_setting', 1)
            ->addParam(':is_open', 1)
            ->addParam(':is_enable', 1)
            ->setOrder('`sort_order` ASC')
            ->queryAll();
    }

    /**
     * 获取模板配置菜单
     * @return array
     * @throws \Exception
     */
    public function getReplaceSetting()
    {
        return Pub::getApp()->getDb()->getFindBuilder()
            ->setTable('pub_replace_setting')
            ->setSelect('`key`,`name`')
            ->addWhere('`is_open`=:is_open')
            ->addParam(':is_open', 1)
            ->setOrder('`sort_order` ASC')
            ->queryAll();
    }

    /**
     * 构建 cache-content ： 在 @link init() 之后运行
     * @throws \Exception
     */
    protected function generateContent()
    {
        $this->render('left-menu-setting', [
            'isSuper' => $this->isSuper,
            'siteSetting' => $this->getSiteSetting(),
            'replaceSetting' => $this->getReplaceSetting(),
        ]);
    }
}