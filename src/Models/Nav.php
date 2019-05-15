<?php
// 申明命名空间
namespace Admin\Models;

// 引用类
use Abstracts\DbModel;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-14
 * Version      :   1.0
 *
 * This is the model class for table "pub_nav".
 * The followings are the available columns in table 'pub_nav':
 *
 * @property integer id
 * @property integer parent_id
 * @property integer is_category
 * @property string label
 * @property string url
 * @property integer sort_order
 * @property integer is_enable
 * @property integer is_open
 * @property integer is_blank
 * @property string description
 */
class Nav extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|Nav
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 数据表名
     * @return string
     */
    public function tableName()
    {
        return 'pub_nav';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['parent_id, is_category, sort_order, is_enable, is_open, is_blank', 'required'],
            ['parent_id, is_category, sort_order, is_enable, is_open, is_blank', 'numerical', 'integerOnly' => true],
            ['label, url', 'string', 'maxLength' => 50],
            ['description', 'string', 'maxLength' => 255],
        ];
    }

    /**
     * 数据表关联
     * @return array
     */
    public function relations()
    {
        return [
            'subOptionCount' => [self::STAT, '\Admin\Models\Nav', 'parent_id'],
        ];
    }

    /**
     * 获取属性标签（name=>label）
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'parent_id' => '父级ID',
            'is_category' => '是否分类导航',
            'label' => '显示标签',
            'url' => '导航url',
            'sort_order' => '排序',
            'is_enable' => '启用状态',
            'is_open' => '是否开放',
            'is_blank' => '是否新开窗口',
            'description' => '描述',
        ];
    }

    /**
     * 在数据删除之前执行
     * @return bool
     * @throws \Exception
     */
    protected function beforeDelete()
    {
        if ($this->getRelated('subOptionCount') > 0) {
            $this->addError('parent_id', '还有子项目，不能删除');
            return false;
        }
        return true;
    }
}