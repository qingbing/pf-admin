<?php
// 申明命名空间
namespace Admin\Models;
// 引用类
use Abstracts\DbModel;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-18
 * Version      :   1.0
 *
 * This is the model class for table "pub_block_category".
 * The followings are the available columns in table 'pub_block_category':
 *
 * @property string key
 * @property string type
 * @property string name
 * @property string description
 * @property integer sort_order
 * @property integer is_open
 * @property integer is_enable
 * @property string x_flag
 * @property string content
 * @property string create_time
 * @property string update_time
 */
class BlockCategory extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|BlockCategory
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
        return 'pub_block_category';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['type, sort_order, is_open, is_enable', 'required'],
            ['sort_order, is_open, is_enable', 'numerical', 'integerOnly' => true],
            ['key, name, description', 'string', 'maxLength' => 255],
            ['type', 'string', 'maxLength' => 20],
            ['x_flag', 'string', 'maxLength' => 50],
            ['content', 'string'],
            ['create_time, update_time', 'safe'],
        ];
    }

    /**
     * 数据表关联
     * @return array
     */
    public function relations()
    {
        return [
            'subOptionCount' => [self::STAT, '\Admin\Models\BlockOption', 'key'],
        ];
    }

    /**
     * 获取属性标签（name=>label）
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'key' => '引用标识',
            'type' => '类型',
            'name' => '名称',
            'description' => '描述',
            'sort_order' => '排序',
            'is_open' => '是否开放',
            'is_enable' => '启用状态',
            'x_flag' => 'type为content的在线编辑器标识符',
            'content' => '内容',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    const TYPE_CONTENT = 'content';
    const TYPE_CLOUD_WORDS = 'cloud-words';
    const TYPE_LINK_CLOUD_WORDS = 'link-cloud-words';
    const TYPE_IMAGES = 'images';
    const TYPE_LINKS = 'links';
    const TYPE_IMAGE_LINKS = 'image-links';

    /**
     * 区块类型
     * @param string $type
     * @param bool $withAll
     * @return array|null
     */
    static public function types($type = null, $withAll = false)
    {
        $data = [
            '' => '全部',
            self::TYPE_CONTENT => '内容',
            self::TYPE_CLOUD_WORDS => '云词',
            self::TYPE_LINK_CLOUD_WORDS => '链接云词',
            self::TYPE_IMAGES => '图片',
            self::TYPE_LINKS => '链接',
            self::TYPE_IMAGE_LINKS => '图片链接',
        ];
        if (null === $type) {
            if (!$withAll) {
                unset($data['']);
            }
            return $data;
        } else {
            unset($data['']);
            return isset($data[$type]) ? $data[$type] : null;
        }
    }
}