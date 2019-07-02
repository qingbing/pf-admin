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
 * This is the model class for table "pub_static_content".
 * The followings are the available columns in table 'pub_static_content':
 *
 * @property integer id
 * @property string code
 * @property string subject
 * @property string keywords
 * @property string description
 * @property integer sort_order
 * @property string x_flag
 * @property string content
 * @property string op_ip
 * @property integer op_uid
 * @property string created_at
 * @property string updated_at
 */
class StaticContent extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|StaticContent
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
        return 'pub_static_content';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['sort_order', 'required'],
            ['sort_order, op_uid', 'numerical', 'integerOnly' => true],
            ['code', 'string', 'maxLength' => 30],
            ['subject, keywords', 'string', 'maxLength' => 100],
            ['description', 'string', 'maxLength' => 255],
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
            'code' => '引用代码',
            'subject' => '内容主题',
            'keywords' => 'seo的keywords',
            'description' => 'seo的description',
            'sort_order' => '排序',
            'x_flag' => '编辑器标志',
            'content' => '内容',
            'op_ip' => '操作IP',
            'op_uid' => '操作ID',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 在数据保存之前执行
     * @return bool
     * @throws \Exception
     */
    protected function beforeSave()
    {
        // 引用代码验证
        $criteria = new Criteria();
        if (!$this->getIsNewRecord()) {
            $criteria->addWhere('`id`!=:id')
                ->addParam(':id', $this->id);
        }
        $criteria->addWhere('`code`=:code')
            ->addParam(':code', $this->code);
        if ($this->count($criteria) > 0) {
            $this->addError('code', "引用代码{$this->code}已经存在");
            return false;
        }
        // 其他信息准备
        $this->setAttributes([
            'op_uid' => Pub::getUser()->getUid(),
            'op_ip' => Pub::getApp()->getRequest()->getUserHostAddress(),
        ]);
        return true;
    }
}