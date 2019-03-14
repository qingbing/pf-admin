<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Controller;
use Admin\Components\Log;
use Admin\Components\Pub;
use Admin\Models\ReplaceSetting;
use DbSupports\Expression;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-14
 * Version      :   1.0
 */
class ReplaceController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/main';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_REPLACE_SETTING;
    /* @var ReplaceSetting */
    protected $setting;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     * @throws \Exception
     */
    protected function beforeAction($action)
    {
        // 只有超管有权限
        if (!Pub::getUser()->getIsSuper()) {
            $this->throwHttpException(403, '对不起，您无权操作该内容');
        }
        $setting = ReplaceSetting::model()->findByPk($this->getActionParam('key'));
        /* @var ReplaceSetting $setting */
        if (null === $setting) {
            $this->throwHttpException(404, '配置不存在');
        }
        $this->setting = $setting;
        return true;
    }

    /**
     * 默认action : 编辑替换模版内容
     * @throws \Exception
     */
    public function actionIndex()
    {
        $model = $this->setting;
        if (isset($_POST['ReplaceSetting'])) {
            $this->logMessage = '编辑' . $this->setting->name;
            $this->logKeyword = $this->setting->key;
            $model->setAttributes($_POST['ReplaceSetting']);
            // 只验证两个传递的修改字段即可
            if ($model->save(true, ['x_flag', 'content'])) {
                $this->success($this->setting->name . '编辑成功', -1);
            } else {
                $this->failure($this->setting->name . '编辑失败', $model->getErrors());
            }
        }

        // 设置页面标题
        $this->setPageTitle($model->name);
        // 渲染页面
        $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * 恢复默认值
     * @throws \Exception
     */
    public function actionReset()
    {
        $model = $this->setting;
        $this->logMessage = '恢复默认' . $this->setting->name;
        $this->logKeyword = $this->setting->key;
        // 只验证重置content字段即可
        $model->content = new Expression("NULL");
        if ($model->save(true, ['content'])) {
            $this->success($this->setting->name . '恢复默认成功', -1);
        } else {
            $this->failure($this->setting->name . '恢复默认失败', $model->getErrors());
        }
    }
}