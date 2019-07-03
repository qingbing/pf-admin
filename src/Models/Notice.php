<?php
// 申明命名空间
namespace Admin\Models;

// 引用类
use Abstracts\DbModel;
use Admin\Components\Pub;
use Helper\Format;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-17
 * Version      :   1.0
 *
 * This is the model class for table "pub_notice".
 * The followings are the available columns in table 'pub_notice':
 *
 * @property integer id
 * @property string subject
 * @property string keywords
 * @property string description
 * @property integer sort_order
 * @property string content
 * @property string x_flag
 * @property integer read_times
 * @property integer is_publish
 * @property string publish_at
 * @property string expire_at
 * @property integer op_uid
 * @property string op_ip
 * @property string created_at
 * @property string updated_at
 */
class Notice extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|Notice
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
        return 'pub_notice';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['sort_order, read_times, is_publish, expire_at', 'required'],
            ['sort_order, read_times, is_publish, op_uid', 'numerical', 'integerOnly' => true],
            ['subject, keywords', 'string', 'maxLength' => 100],
            ['description', 'string', 'maxLength' => 255],
            ['x_flag', 'string', 'maxLength' => 20],
            ['op_ip', 'string', 'maxLength' => 15],
            ['content, publish_at, expire_at', 'string'],
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
            'subject' => '主题',
            'keywords' => 'seo的keywords',
            'description' => 'seo的description',
            'sort_order' => '排序',
            'content' => '内容',
            'x_flag' => '编辑器标志',
            'read_times' => '浏览次数',
            'is_publish' => '是否发布',
            'publish_at' => '发布时间',
            'expire_at' => '有效时间',
            'op_uid' => '用户ID',
            'op_ip' => '更新IP',
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
        $datetime = Format::datetime();
        $this->setAttributes([
            'op_uid' => Pub::getUser()->getUid(),
            'op_ip' => Pub::getApp()->getRequest()->getUserHostAddress(),
        ]);
        $this->setAttribute('updated_at', $datetime);
        return true;
    }
}