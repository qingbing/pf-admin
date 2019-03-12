<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-12
 * Version      :   1.0
 */

namespace Admin\Models;


use Admin\Components\Pub;
use Helper\Coding;
use Helper\Exception;

class FormSetting extends \Abstracts\FormOption
{
    /**
     * 析构函数后被调用
     * @throws \Exception
     */
    public function init()
    {
        $category = $this->getCategory();
        if (!$category) {
            throw new Exception("不存在的配置分类");
        }
        if (!$category['is_setting']) {
            throw new Exception("表单不是配置分类");
        }
        $setting = $this->getSetting();
        if ($setting) {
            $attributes = Coding::json_decode($setting['content']);
            if (is_array($attributes)) {
                $this->setAttributes($attributes);
            }
        }
    }

    /**
     * 获取 component-db
     * @return \Components\Db|null
     * @throws \Helper\Exception
     */
    protected function db()
    {
        return Pub::getApp()->getDb();
    }

    /**
     * 获取表单配置分类
     * @return array
     * @throws \Exception
     */
    protected function getCategory()
    {
        return $this->db()->getFindBuilder()
            ->setTable('pub_form_category')
            ->setWhere('`key`=:key')
            ->addParam(':key', $this->getScenario())
            ->queryRow();
    }

    /**
     * 获取设置信息
     * @return array
     * @throws \Exception
     */
    protected function getSetting()
    {
        return $this->db()->getFindBuilder()
            ->setTable('pub_form_setting')
            ->setWhere('`key`=:key')
            ->addParam(':key', $this->getScenario())
            ->queryRow();
    }

    /**
     * 定义的表单项目
     * @return mixed
     * @throws \Exception
     */
    public function getOptions()
    {
        return $this->db()->getFindBuilder()
            ->setTable('pub_form_option')
            ->setWhere('`key`=:key AND `is_enable`=:is_enable')
            ->addParam(':key', $this->getScenario())
            ->addParam(':is_enable', 1)
            ->setOrder('`sort_order` ASC, `id` ASC')
            ->queryAll();
    }

    /**
     * 保存配置
     * @return bool
     * @throws \Exception
     */
    public function save()
    {
        if ($this->validate()) {
            $setting = $this->getSetting();
            if ($setting) {
                $this->db()->getUpdateBuilder()
                    ->setTable('pub_form_setting')
                    ->addColumn('content', Coding::json_encode($this->getAttributes()))
                    ->setWhere('`key`=:key')
                    ->addParam(':key', $this->getScenario())
                    ->execute();
            } else {
                $this->db()->getInsertBuilder()
                    ->setTable('pub_form_setting')
                    ->addColumn('key', $this->getScenario())
                    ->addColumn('content', Coding::json_encode($this->getAttributes()))
                    ->execute();
            }
            return true;
        }
        return false;
    }
}