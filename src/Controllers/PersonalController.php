<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Controller;
use Admin\Components\Log;
use Admin\Components\Pub;
use Admin\Models\FormResetPassword;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-06
 * Version      :   1.0
 */
class PersonalController extends Controller
{
    /* @var string nav标记 */
    public $navFlag = 'home';

    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_PERSONAL;

    /**
     * 浏览个人信息
     * @throws \Helper\Exception
     */
    public function actionIndex()
    {
        // 数据准备
        $model = Pub::getUser()->getUserInfo();
        // 设置页面标题
        $this->setPageTitle('个人信息');
        // 渲染页面
        $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * 修改个人信息
     * @throws \Exception
     */
    public function actionChangeInfo()
    {
        // 数据准备
        $model = Pub::getUser()->getUserInfo();
        // 表单提交处理
        if (isset($_POST['User'])) {
            $model->setAttributes($_POST['User']);
            $this->logMessage = '修改个人信息';
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('修改个人信息成功', -1);
            } else {
                $this->failure('修改个人信息失败', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('修改个人信息');
        // 渲染页面
        $this->render('change_info', [
            'model' => $model,
        ]);
    }

    /**
     * 修改个人头像
     * @throws \Exception
     */
    public function actionChangeAvatar()
    {
        // 数据准备
        $model = Pub::getUser()->getUserInfo();
        // 表单提交处理
        if (isset($_POST['User'])) {
            $this->logMessage = '上传头像';
            if (true === $model->uploadAvatar($_POST['User'])) {
                $this->success('上传头像成功', -1);
            } else {
                $this->failure('上传头像失败', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('上传头像');
        // 渲染页面
        $this->render('change_avatar', [
            'model' => $model,
        ]);
    }

    /**
     * 修改个人密码
     * @throws \Exception
     */
    public function actionResetPassword()
    {
        // 数据准备
        $model = new FormResetPassword();
        // 表单提交处理
        if (isset($_POST['FormResetPassword'])) {
            $this->logMessage = '修改密码';
            $model->setAttributes($_POST['FormResetPassword']);
            if ($model->save()) {
                $this->success('修改密码成功', -1);
            } else {
                $this->failure('修改密码失败', $model->getErrors());
            }
        }
        $user = Pub::getUser()->getUserInfo();
        // 设置页面标题
        $this->setPageTitle('重置密码');
        // 渲染页面
        $this->render('reset_password', [
            'user' => $user,
            'model' => $model,
        ]);
    }
}