<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Components;


use Admin\Models\LoginForm;
use Admin\Models\User;

class WebUser extends \Abstracts\WebUser
{
    /**
     * 获取当前登录用户的信息
     * @return \Abstracts\DbModel|mixed|User|null
     * @throws \Exception
     */
    protected function getUser()
    {
        return User::model()->findByPk($this->getUid());
    }

    /**
     * 登录成功后调用，如果使用需要子类重写
     * @param \Admin\Components\UserIdentity $identity
     * @throws \Exception
     */
    protected function afterLogin($identity)
    {
        $user = $identity->getUser();
        if ($user->afterLogin()) {
            // 登录后记录日志等相关信息
            $this->setUid($user->uid);
            $this->setState('nickname', $user->nickname);
            $this->setIsSuper(!!$user->is_super);
            Log::getInstance()->operate(true, Log::OPERATE_TYPE_LOGIN, '用户登录', '', [
                'login_times' => ($user->login_times + 1),
            ]);
        }
        // 销毁登录消息
        \Captcha::getCaptchaAction(LoginForm::$captchaAction)->destroyState();
        parent::afterLogin($identity);
    }

    /**
     * 退出之前调用，如果使用需要子类重写
     * @return bool
     * @throws \Exception
     */
    protected function beforeLogout()
    {
        Log::getInstance()->operate(true, Log::OPERATE_TYPE_LOGIN, '用户登录退出');
        return true;
    }
}