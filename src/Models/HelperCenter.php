<?php
// 申明命名空间
namespace Admin\Models;

// 引用类
use Abstracts\DbModel;
use Admin\Components\Pub;
use DbSupports\Builder\Criteria;
use Helper\Format;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-17
 * Version      :   1.0
 *
 * This is the model class for table "pub_helper_center".
 * The followings are the available columns in table 'pub_helper_center':
 *
 * @property integer id
 * @property integer parent_id
 * @property string label
 * @property string code
 * @property string subject
 * @property string keywords
 * @property string description
 * @property integer sort_order
 * @property integer is_enable
 * @property integer is_category
 * @property string content
 * @property string x_flag
 * @property integer op_uid
 * @property string op_ip
 * @property string created_at
 * @property string updated_at
 */
class HelperCenter extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|HelperCenter
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
        return 'pub_helper_center';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['parent_id, sort_order, is_enable, is_category', 'required'],
            ['parent_id, sort_order, is_enable, is_category, op_uid', 'numerical', 'integerOnly' => true],
            ['label, code', 'string', 'maxLength' => 30],
            ['subject', 'string', 'maxLength' => 100],
            ['keywords, description', 'string', 'maxLength' => 255],
            ['x_flag', 'string', 'maxLength' => 20],
            ['op_ip', 'string', 'maxLength' => 15],
            ['content', 'string'],
            ['created_at, updated_at', 'safe'],
        ];
    }

    /**
     * 数据表关联
     * @return array
     */
    public function relations()
    {
        return [
            'subOptionCount' => [self::STAT, '\Admin\Models\HelperCenter', 'parent_id'],
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
            'label' => '显示标签',
            'code' => '引用代码',
            'subject' => '主题',
            'keywords' => 'seo的keywords',
            'description' => 'seo的description',
            'sort_order' => '排序',
            'is_enable' => '是否启用',
            'is_category' => '是否分类',
            'content' => '内容',
            'x_flag' => '编辑器标志',
            'op_uid' => '操作ID',
            'op_ip' => '操作IP',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 在数据保存之前执行
     * @return bool
     * @throws \Exception
     * @throws \ReflectionException
     */
    protected function beforeSave()
    {
        if ('' != $this->code) {
            $criteria = new Criteria();
            $criteria->addWhere('`code`=:code')
                ->addParam(':code', $this->code);
            if (!$this->getIsNewRecord()) {
                $criteria->addWhere('`id`!=:id')
                    ->addParam(':id', $this->id);
            }
            if ($this->count($criteria) > 0) {
                $this->addError('code', "引用代码{$this->code}已经存在");
                return false;
            }
        }

        // 赋值操作信息
        $this->setAttributes([
            'op_uid' => Pub::getUser()->getUid(),
            'op_ip' => Pub::getApp()->getRequest()->getUserHostAddress(),
        ]);
        if (!$this->getIsNewRecord()) {
            $this->updated_at = Format::datetime();
        }
        return true;
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