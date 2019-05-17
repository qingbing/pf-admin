<?php
// 申明命名空间
namespace Admin\Models;

// 引用类
use Abstracts\DbModel;
use DbSupports\Builder\Criteria;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-17
 * Version      :   1.0
 *
 * This is the model class for table "pub_form_option".
 * The followings are the available columns in table 'pub_form_option':
 *
 * @property integer id
 * @property string key
 * @property string code
 * @property string label
 * @property string default
 * @property string description
 * @property integer sort_order
 * @property string input_type
 * @property string data_type
 * @property string input_data
 * @property integer allow_empty
 * @property string compare_field
 * @property string pattern
 * @property string tip_msg
 * @property string error_msg
 * @property string empty_msg
 * @property integer min
 * @property string min_msg
 * @property integer max
 * @property string max_msg
 * @property string file_extensions
 * @property string callback
 * @property string ajax_url
 * @property string tip_id
 * @property string css_id
 * @property string css_class
 * @property string css_style
 * @property integer is_enable
 */
class FormOption extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|FormOption
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
        return 'pub_form_option';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['sort_order, input_type, allow_empty, is_enable', 'required'],
            ['sort_order, allow_empty, min, max, is_enable', 'numerical', 'integerOnly' => true],
            ['key, code, label, default, compare_field, callback, tip_id, css_id, css_class', 'string', 'maxLength' => 100],
            ['description', 'string', 'maxLength' => 255],
            ['pattern, tip_msg, error_msg, empty_msg, min_msg, max_msg, file_extensions, ajax_url, css_style', 'string', 'maxLength' => 200],
            ['input_type', 'in', 'range' => ['text', 'select', 'textarea', 'editor', 'checkbox', 'checkbox_list', 'radio_list', 'password', 'hidden', 'file']],
            ['data_type', 'in', 'range' => ['required', 'email', 'url', 'ip', 'phone', 'mobile', 'contact', 'fax', 'zip', 'time', 'date', 'username', 'password', 'compare', 'preg', 'string', 'numeric', 'integer', 'money', 'file', 'select', 'choice', 'checked']],
            ['input_data', 'string'],
        ];
    }

    /**
     * 数据表关联
     * @return array
     */
    public function relations()
    {
        return [];
    }

    /**
     * 获取属性标签（name=>label）
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'key' => '所属表单分类（来自form_category）',
            'code' => '字段名',
            'label' => '表单显示名',
            'default' => '默认值',
            'description' => '分类配置描述',
            'sort_order' => '当前分类排序',
            'input_type' => '输入类型',
            'data_type' => '前端数据验证',
            'input_data' => '非直接输入框的json键值对',
            'allow_empty' => '是否允许为空',
            'compare_field' => '对比字段，只对compare的数据类型有效，对应于compareField',
            'pattern' => '正则匹配表达式，对正则匹配验证有效',
            'tip_msg' => '页面提示信息，对应于tipMsg',
            'error_msg' => '页面错误提示信息，对应于errorMsg',
            'empty_msg' => '信息为空提示信息，对应于emptyMsg',
            'min' => '最小值/最小长度，对应于min,minLength',
            'min_msg' => '最小值提示信息，对应于minErrorMsg',
            'max' => '最大值/最大长度，对应于max,maxLength',
            'max_msg' => '最大值提示信息，对应于maxErrorMsg',
            'file_extensions' => '文件上传时支持的文件后缀类型,用|分隔',
            'callback' => '验证回调函数，在页面中需要定义对应的回调函数',
            'ajax_url' => 'ajax验证URL',
            'tip_id' => '表单验证的信息提示框',
            'css_id' => '表单元素ID',
            'css_class' => '表单元素的类',
            'css_style' => '输入表单元素的样式',
            'is_enable' => '表单项目启用状态',
        ];
    }

    /**
     * 验证通过后执行
     * @throws \Exception
     */
    protected function afterValidate()
    {
        $criteria = new Criteria();
        $criteria->addWhere('`key`=:key')
            ->addParam(':key', $this->key);

        $cCode = clone($criteria);
        $cCode->addWhere('`code`=:code')
            ->addParam(':code', $this->code);

        $cLabel = clone($criteria);
        $cLabel->addWhere('`label`=:label')
            ->addParam(':label', $this->label);
        if ($this->getIsNewRecord()) {
            if (self::model()->count($cCode) > 0) {
                $this->addError('code', "该表单配置选项中已经存在\"{$this->code}\"");
            }
            if (self::model()->count($cLabel) > 0) {
                $this->addError('label', "该表单配置选项中已经存在\"{$this->label}\"");
            }
        } else {
            $cCode->addWhere('`id`!=:id')
                ->addParam(':id', $this->id);
            $cLabel->addWhere('`id`!=:id')
                ->addParam(':id', $this->id);
            if (self::model()->count($cCode) > 0) {
                $this->addError('code', "该表单配置选项中已经存在\"{$this->code}\"");
            }
            if (self::model()->count($cLabel) > 0) {
                $this->addError('label', "该表单配置选项中已经存在\"{$this->label}\"");
            }
        }
    }
}