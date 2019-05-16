<?php
// 申明命名空间
namespace Admin\Models;

// 引用类
use Abstracts\DbModel;
use DbSupports\Builder\Criteria;
use Helper\Exception;
use Helper\Format;
use Tools\UploadFile;
use Tools\UploadManager;

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
 * @property string src
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
            ['src, content', 'string'],
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
            'src' => '图片地址',
            'x_flag' => 'type为content的在线编辑器标识符',
            'content' => '内容',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    const TYPE_CONTENT = 'content';
    const TYPE_IMAGE_LINK = 'image-link';
    const TYPE_CLOUD_WORDS = 'cloud-words';
    const TYPE_CLOUD_WORDS_LINKS = 'cloud-words-links';
    const TYPE_LIST = 'list';
    const TYPE_LIST_LINKS = 'list-links';
    const TYPE_IMAGES = 'images';
    const TYPE_IMAGES_LINKS = 'images-links';

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
            self::TYPE_IMAGE_LINK => '图片',
            self::TYPE_CLOUD_WORDS => '云词',
            self::TYPE_CLOUD_WORDS_LINKS => '链接云词',
            self::TYPE_LIST => '列表',
            self::TYPE_LIST_LINKS => '链接列表',
            self::TYPE_IMAGES => '图片集',
            self::TYPE_IMAGES_LINKS => '链接图片集',
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

    /**
     * 验证通过后执行
     * @throws \Exception
     */
    protected function afterValidate()
    {
        // 查询组件准备
        $criteria = new Criteria();
        if ($this->getIsNewRecord()) {
            // key 验证
            $cKey = clone $criteria;
            $cKey->addWhere('`key`=:key')
                ->addParam(':key', $this->key);
            if ($this->count($cKey) > 0) {
                $this->addError('key', "引用标识{$this->key}已经存在");
                return false;
            }
        } else {
            $criteria->addWhere('`key`!=:key')
                ->addParam(':key', $this->key);
        }
        // 标志验证
        $criteria->addWhere('`name`=:name')
            ->addParam(':name', $this->name);
        if ($this->count($criteria) > 0) {
            $this->addError('name', "别名{$this->name}已经存在");
            return false;
        }
    }

    /**
     * 在数据保存之前执行
     * @return bool
     * @throws \Exception
     */
    protected function beforeSave()
    {
        if (self::TYPE_IMAGE_LINK == $this->type) {
            $upload = UploadFile::getInstance($this, 'src');
            if ($upload) {
                // 保存老信息
                $blockPath = UploadManager::getPath('block');
                if (!is_dir($blockPath)) {
                    @mkdir($blockPath, 0777);
                }
                $old_file = $blockPath . DS . $this->src;
                $filename = $this->key . '_' . time() . '.' . $upload->getExtensionName();
                // 上传文件
                if (!$upload->saveAs($blockPath . DS . $filename)) {
                    throw new Exception('上传图像错误，请联系管理员');
                }
                // 保存信息
                $this->src = $filename;
                // 删除旧图片
                if (is_file($old_file)) {
                    @unlink($old_file);
                }
            }
        }
        $datetime = Format::datetime();
        $this->setAttribute('update_time', $datetime);
        if ($this->getIsNewRecord()) {
            $this->setAttribute('create_time', $datetime);
        }
        return true;
    }

    /**
     * 获取最终显示的图片链接
     * @return string|null
     */
    public function getImageSrc()
    {
        if ('' == $this->src) {
            return null;
        }
        return UploadManager::getUrl('block') . $this->src;
    }
}