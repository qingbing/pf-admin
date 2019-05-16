<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-12
 * Version      :   1.0
 */

namespace Admin\Models;


use Helper\Coding;
use Helper\Exception;

class FormSetting extends \Tools\FormSetting
{
    /**
     * 析构函数后被调用
     * @throws \Exception
     */
    public function init()
    {
        parent::init();
        if (!$this->category['is_setting']) {
            throw new Exception("表单不是配置分类");
        }
    }

    /**
     * 保存配置
     * @return bool
     * @throws \Exception
     */
    public function save()
    {
        if ($this->validate()) {
            \PF::app()->getCache()->delete(self::cacheKey($this->getScenario()));
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

    /**
     * 返回删除结果
     * @return int
     * @throws \Exception
     */
    public function reset()
    {
        return $this->db()->getDeleteBuilder()
            ->setTable('pub_form_setting')
            ->setWhere('`key`=:key')
            ->addParam(':key', $this->getScenario())
            ->execute();
    }
}