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
 * Date         :   2019-05-14
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
 * @property string ip
 * @property integer uid
 * @property string create_time
 * @property string update_time
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
            ['sort_order, uid', 'numerical', 'integerOnly' => true],
            ['code, subject, keywords, description', 'string', 'maxLength' => 255],
            ['x_flag', 'string', 'maxLength' => 20],
            ['ip', 'string', 'maxLength' => 15],
            ['content', 'string'],
            ['create_time, operate_time', 'safe'],
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
            'ip' => '更新IP',
            'uid' => '用户ID',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    /**
     * 在数据保存之前执行
     * @return bool
     * @throws \Exception
     */
    protected function beforeSave()
    {
        $datetime = Format::datetime();
        $this->setAttributes([
            'uid' => Pub::getUser()->getUid(),
            'ip' => Pub::getApp()->getRequest()->getUserHostAddress(),
        ]);
        $this->setAttribute('update_time', $datetime);
        return true;
    }
}