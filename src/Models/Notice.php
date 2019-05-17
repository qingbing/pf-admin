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
 * @property string publish_time
 * @property string expire_time
 * @property string create_time
 * @property integer uid
 * @property string ip
 * @property string update_time
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
            ['sort_order, read_times, is_publish, expire_time', 'required'],
            ['sort_order, read_times, is_publish, uid', 'numerical', 'integerOnly' => true],
            ['subject, keywords', 'string', 'maxLength' => 100],
            ['description', 'string', 'maxLength' => 255],
            ['x_flag', 'string', 'maxLength' => 20],
            ['ip', 'string', 'maxLength' => 15],
            ['content, publish_time, expire_time', 'string'],
            ['create_time, update_time', 'safe'],
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
            'publish_time' => '发布时间',
            'expire_time' => '有效时间',
            'create_time' => '创建时间',
            'uid' => '用户ID',
            'ip' => '更新IP',
            'update_time' => '更新时间',
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
            'uid' => Pub::getUser()->getUid(),
            'ip' => Pub::getApp()->getRequest()->getUserHostAddress(),
        ]);
        $this->setAttribute('update_time', $datetime);
        if ($this->getIsNewRecord()) {
            // 插入
            $this->create_time = $datetime;
        }
        return true;
    }
}