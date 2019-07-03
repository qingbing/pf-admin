<?php
// 申明命名空间
namespace Admin\Models;

// 引用类
use Abstracts\DbModel;
use Admin\Components\Pub;
use DbSupports\Builder\Criteria;
use DbSupports\Expression;
use Helper\Exception;
use Tools\UploadFile;
use Tools\UploadManager;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 *
 * This is the model class for table "admin_user".
 * The followings are the available columns in table 'admin_user':
 *
 * @property integer uid
 * @property string username
 * @property string password
 * @property string nickname
 * @property string real_name
 * @property string sex
 * @property string birthday
 * @property string avatar
 * @property string mobile
 * @property string phone
 * @property string qq
 * @property string address
 * @property string zip_code
 * @property string refer_uid
 * @property string register_ip
 * @property string register_at
 * @property int login_times
 * @property string last_login_ip
 * @property string last_login_at
 * @property integer is_super
 * @property integer is_enable
 */
class User extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|User
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
        return 'admin_user';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['sex, refer_uid, login_times, is_super, is_enable', 'required'],
            ['is_super, is_enable', 'numerical', 'integerOnly' => true],
            ['username', 'string', 'maxLength' => 50],
            ['password', 'string', 'maxLength' => 32],
            ['nickname, real_name', 'string', 'maxLength' => 30],
            ['avatar', 'string', 'maxLength' => 200],
            ['mobile, phone, qq, register_ip, last_login_ip', 'string', 'maxLength' => 15],
            ['address', 'string', 'maxLength' => 255],
            ['zip_code', 'string', 'maxLength' => 6],
            ['refer_uid, login_times', 'string', 'maxLength' => 10],
            ['sex', 'in', 'range' => ['1', '2', '3']],

            ['birthday', 'date'],
            ['last_login_at', 'datetime'],

            ['nickname, username', self::UNIQUE],
            ['username', 'email'],

            ['register_at', 'safe'],
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
            'uid' => 'UID',
            'username' => '用户名',
            'password' => '密码',
            'nickname' => '昵称',
            'real_name' => '姓名',
            'sex' => '性别',
            'birthday' => '生日',
            'avatar' => '头像',
            'mobile' => '手机号码',
            'phone' => '固定电话',
            'qq' => 'QQ',
            'address' => '联系地址',
            'zip_code' => '邮政编码',
            'refer_uid' => '引荐人UID',
            'register_ip' => '注册IP',
            'register_at' => '注册时间',
            'login_times' => '登录次数',
            'last_login_ip' => '登录IP',
            'last_login_at' => '登录时间',
            'is_super' => '是否超管',
            'is_enable' => '启用状态',
        ];
    }

    /**
     * 在数据保存之前执行
     * @return bool
     * @throws \Exception
     */
    protected function beforeSave()
    {
        // 查询组件准备
        $criteria = new Criteria();
        if (!$this->getIsNewRecord()) {
            $criteria->addWhere('`uid`!=:uid')
                ->addParam(':uid', $this->uid);
        }
        // 标签验证
        $cUsername = clone $criteria;
        $cUsername->addWhere('`username`=:username')
            ->addParam(':username', $this->username);
        if ($this->count($cUsername) > 0) {
            $this->addError('username', "用户名{$this->username}已经存在");
            return false;
        }
        // 标志验证
        $cNickname = clone $criteria;
        $cNickname->addWhere('`nickname`=:nickname')
            ->addParam(':nickname', $this->nickname);
        if ($this->count($cNickname) > 0) {
            $this->addError('nickname', "用户昵称{$this->nickname}已经存在");
            return false;
        }
        if ('' === $this->birthday) {
            $this->birthday = null;
        }
        return true;
    }

    /**
     * 用户登录成功后进行日志记录
     * @throws \Exception
     */
    public function afterLogin()
    {
        $login_times = $this->login_times + 1;
        $login_ip = Pub::getApp()->getRequest()->getUserHostAddress();
        $this->setAttributes([
            'login_times' => $login_times,
            'last_login_ip' => $login_ip,
            'last_login_at' => new Expression('NOW()'),
        ], false);
        return $this->save(false);
    }

    /**
     * 创建数据库密码
     * @param string $password
     * @return string
     */
    public function generatePassword($password)
    {
        return md5(md5($password));
    }

    /**
     * 输入密码对比
     * @param string $password
     * @return bool
     */
    public function comparePassword($password)
    {
        return $this->password == $this->generatePassword($password);
    }

    /**
     * 上传个人头像
     * @param array $data
     * @return array|bool
     * @throws \Exception
     */
    public function uploadAvatar($data)
    {
        // 保存老信息
        $old_file = UploadManager::getPath('admin/avatars') . DS . $this->avatar;
        // 设置上传信息
        $this->setAttributes($data);
        $upload = UploadFile::getInstance($this, 'avatar');
        if (null === $upload) {
            throw new Exception('请选择要上传的头像图片');
        }
        $filename = md5($this->uid . time()) . '.' . $upload->getExtensionName();

        // 上传文件
        if (!$upload->saveAs(UploadManager::getPath('admin/avatars/') . DS . $filename)) {
            throw new Exception('上传图像错误，请联系管理员');
        }
        // 保存信息
        $this->avatar = $filename;
        if (!$this->save()) {
            return $this->getErrors();
        }
        // 删除就头像
        if (is_file($old_file)) {
            @unlink($old_file);
        }
        return true;
    }

    /**
     * 返回用户的头像地址
     * @return string
     */
    public function getAvatarUrl()
    {
        if ($this->avatar) {
            return UploadManager::getUrl('admin/avatars') . $this->avatar;
        } else {
            return UploadManager::getUrl('admin') . 'avatar.jpg';
        }
    }

    /**
     * 后台图像展示
     * @return string
     */
    public function showAvatar()
    {
        return '<img src="' . $this->getAvatarUrl() . '" width="200px" height="200px"/>';
    }

    /**
     * 在数据插入之前执行
     * @return bool
     * @throws Exception
     */
    protected function beforeInsert()
    {
        $this->refer_uid = Pub::getUser()->getUid();
        $this->register_ip = Pub::getApp()->getRequest()->getUserHostAddress();
        return true;
    }

    /**
     * 在数据删除之后执行
     */
    protected function afterDelete()
    {
        $file = UploadManager::getPath('admin/avatars') . DS . $this->avatar;
        if (is_file($file)) {
            @unlink($file);
        }
    }
}