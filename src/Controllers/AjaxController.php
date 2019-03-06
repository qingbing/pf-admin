<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Controller;
use Admin\Components\Pub;
use Admin\Models\User;
use DbSupports\Builder\Criteria;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 */
class AjaxController extends Controller
{
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = false;

    /**
     * 检查用户名的唯一性
     * @throws \Exception
     */
    public function actionUniqueUsername()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`username`=:username')
            ->addParam(':username', $fixer['param']);
        if (isset($fixer['uid']) && $fixer['uid']) {
            $criteria->addWhere('`uid`!=:uid')
                ->addParam(':uid', $fixer['uid']);
        }
        $count = User::model()->count($criteria);
        // 返回验证结果
        if ($count > 0) {
            $this->failure("用户名\"{$fixer['param']}\"已经存在");
        } else {
            $this->success('success');
        }
    }

    /**
     * 检查用户昵称的唯一性
     * @throws \Exception
     */
    public function actionUniqueNickname()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`nickname`=:nickname')
            ->addParam(':nickname', $fixer['param']);
        if (isset($fixer['uid']) && $fixer['uid']) {
            $criteria->addWhere('`uid`!=:uid')
                ->addParam(':uid', $fixer['uid']);
        }
        $count = User::model()->count($criteria);
        // 返回验证结果
        if ($count > 0) {
            $this->failure("昵称\"{$fixer['param']}\"已经存在");
        } else {
            $this->success('success');
        }
    }

    /**
     * 验证登录密码
     * @throws \Exception
     */
    public function actionValidMyPassword()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $user = Pub::getUser()->getUserInfo();
        /* @var $user User */
        // 返回验证结果
        if ($user->comparePassword($fixer['param'])) {
            $this->success('success');
        } else {
            $this->failure("登录密码不正确");
        }
    }
}