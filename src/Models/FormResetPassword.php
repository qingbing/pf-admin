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

class FormResetPassword extends FormModel
{
    /* @var string 旧密码 */
    public $oldPassword;
    /* @var string 新密码 */
    public $newPassword;
    /* @var string 确认新密码 */
    public $confirmPassword;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['oldPassword, newPassword, confirmPassword', 'string'],
            // password needs to be authenticated
            ['oldPassword', 'authenticate'],
            ['newPassword, confirmPassword', 'string', 'minLength' => 6, 'maxLength' => 30],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }

    /**
     * 获取属性标签（name=>label）
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'oldPassword' => '旧 密 码',
            'newPassword' => '新 密 码',
            'confirmPassword' => '确认密码',
        ];
    }

    /**
     * 密码验证
     * @param string $attribute
     * @param mixed $params
     * @throws \Helper\Exception
     */
    public function authenticate($attribute, $params)
    {
        $user = Pub::getUser()->getUserInfo();
        /* @var User $user */
        if (!$user->comparePassword($this->{$attribute})) {
            $this->addError($attribute, '原始密码输入不正确');
        }
    }

    /**
     * 保存密码修改
     * @return array|bool
     * @throws \Exception
     */
    public function save()
    {
        if (!$this->validate()) {
            return $this->getErrors();
        }
        $user = Pub::getUser()->getUserInfo();
        /* @var User $user */
        $user->password = $user->generatePassword($this->newPassword);
        if (!$user->save()) {
            return $user->getErrors();
        }
        return true;
    }
}