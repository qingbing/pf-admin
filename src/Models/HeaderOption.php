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
 * This is the model class for table "pub_header_option".
 * The followings are the available columns in table 'pub_header_option':
 *
 * @property integer id
 * @property string key
 * @property string code
 * @property string label
 * @property string default
 * @property string width
 * @property integer sort_order
 * @property string css_class
 * @property integer is_required
 * @property integer is_default
 * @property integer is_enable
 * @property integer is_sortable
 */
class HeaderOption extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|HeaderOption
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
        return 'pub_header_option';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['default, sort_order, is_required, is_default, is_enable, is_sortable', 'required'],
            ['sort_order, is_required, is_default, is_enable, is_sortable', 'numerical', 'integerOnly' => true],
            ['key, code, label', 'string', 'maxLength' => 100],
            ['default', 'string', 'maxLength' => 255],
            ['width', 'string', 'maxLength' => 20],
            ['css_class', 'string', 'maxLength' => 30],
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
            'id' => 'ID',
            'key' => '表头类型',
            'code' => '字段名',
            'label' => '显示名',
            'default' => '默认值',
            'width' => '宽度',
            'sort_order' => '分类排序',
            'css_class' => '显示位置',
            'is_required' => '是否必选',
            'is_default' => '是否默认',
            'is_enable' => '是否开启',
            'is_sortable' => '可排序',
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
                $this->addError('code', "该表头配置选项中已经存在\"{$this->code}\"");
            }
            if (self::model()->count($cLabel) > 0) {
                $this->addError('label', "该表头配置选项中已经存在\"{$this->label}\"");
            }
        } else {
            $cCode->addWhere('`id`!=:id')
                ->addParam(':id', $this->id);
            $cLabel->addWhere('`id`!=:id')
                ->addParam(':id', $this->id);
            if (self::model()->count($cCode) > 0) {
                $this->addError('code', "该表头配置选项中已经存在\"{$this->code}\"");
            }
            if (self::model()->count($cLabel) > 0) {
                $this->addError('label', "该表头配置选项中已经存在\"{$this->label}\"");
            }
        }
        if ($this->is_required) {
            $this->is_enable = 1;
        } else {
            $this->is_default = 0;
        }
    }

    /**
     * 元素显示位置
     * @return array
     */
    public function cssClass()
    {
        return [
            'text-left' => '靠左',
            'text-center' => '居中',
            'text-right' => '靠右',
        ];
    }
}