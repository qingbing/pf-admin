<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Models;


use Abstracts\FormModel;
use Admin\Components\Pub;
use Admin\Components\UserIdentity;

class LoginForm extends FormModel
{
    /* @var string 验证码route */
    public static $captchaAction = '//admin/login/captcha';
    /* @var string 登录账户 */
    public $username;
    /* @var string 密码 */
    public $password;
    /* @var string 验证码 */
    public $verifyCode;
    /* @var \Admin\Components\UserIdentity 认证组件 */
    private $_identity;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'email', 'allowEmpty' => false],
            ['password', 'password', 'allowEmpty' => false],
            ['password', 'authenticate'],
            ['verifyCode', 'string', 'allowEmpty' => false],
            ['verifyCode', \Captcha::VALIDATOR, 'captchaAction' => self::$captchaAction, 'allowEmpty' => false],
        ];
    }

    /**
     * 获取属性标签，该属性在必要时需要被实例类重写
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => '登录账号',
            'password' => '密　码',
            'verifyCode' => '验证码',
        ];
    }

    /**
     * 验证用户登录密码
     * @param string $attribute
     * @throws \Exception
     */
    public function authenticate($attribute)
    {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            if (0 != $this->_identity->authenticate()) {
                $this->addError($attribute, $this->_identity->getErrorMsg());
            }
        }
    }

    /**
     * 用户登录
     * @return bool
     * @throws \Exception
     */
    public function login()
    {
        if ($this->validate()) {
            if (!Pub::getUser()->login($this->_identity)) {
                $this->addError('username', "登录失败");
            } else {
                return true;
            }
        }
        return false;
    }
}