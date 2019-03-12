<?php
// 申明命名空间
namespace Admin\Models;
// 引用类
use Abstracts\DbModel;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-11
 * Version      :   1.0
 *
 * This is the model class for table "pub_form_category".
 * The followings are the available columns in table 'pub_form_category':
 * 
 * @property string key
 * @property string name
 * @property string description
 * @property integer sort_order
 * @property integer is_setting
 * @property integer is_open
 * @property integer is_enable
 */
class FormCategory extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|FormCategory
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
        return 'pub_form_category';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['sort_order, is_setting, is_open, is_enable', 'required'],
            ['sort_order, is_setting, is_open, is_enable', 'numerical', 'integerOnly' => true],
            ['key, name, description', 'string', 'maxLength' => 255],
        ];
    }

    /**
     * 数据表关联
     * @return array
     */
    public function relations()
    {
        return [
            'subOptionCount' => [self::STAT, '\Admin\Models\FormOption', 'key'],
        ];
    }

    /**
     * 获取属性标签（name=>label）
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'key' => '标志符',
            'name' => '别名',
            'description' => '描述',
            'sort_order' => '排序',
            'is_setting' => '配置类型', // [0:搜集表单，1:配置项]
            'is_open' => '是否开放',
            'is_enable' => '启用状态',
        ];
    }
}