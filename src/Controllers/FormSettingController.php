<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Controller;
use Admin\Components\Log;
use Admin\Components\Pub;
use Admin\Models\FormCategory;
use Admin\Models\FormSetting;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-12
 * Version      :   1.0
 */
class FormSettingController extends Controller
{
    /* @var string nav标记 */
    public $navFlag = 'setting';

    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_FORM_SETTING;
    /* @var FormCategory */
    protected $category;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     * @throws \Exception
     */
    protected function beforeAction($action)
    {
        if (!Pub::getUser()->getIsSuper()) {
            $this->throwHttpException(403, '对不起，您无权操作该模块');
        }
        $category = FormCategory::model()->findByPk($this->getActionParam('key'));
        /* @var FormCategory $category */
        if (null === $category) {
            $this->throwHttpException(404, '表头不存在');
        }
        if (!$category->is_open) {
            $this->throwHttpException(403, '对不起，您无权操作该内容');
        }
        if (!$category->is_setting) {
            $this->throwHttpException(403, '对不起，无效访问');
        }
        $this->category = $category;
        return true;
    }

    /**
     * 默认action : 表单配置内容
     * @throws \Exception
     */
    public function actionIndex()
    {
        $model = new FormSetting($this->category->key);
        if (isset($_POST['FormSetting'])) {
            $this->logMessage = '编辑' . $this->category->name;
            $this->logKeyword = $this->category->key;
            $model->setAttributes($_POST['FormSetting']);
            if ($model->save()) {
                $this->success($this->category->name . '编辑成功', -1);
            } else {
                $this->failure($this->category->name . '编辑失败', $model->getErrors());
            }
        }

        // 设置页面标题
        $this->setPageTitle($this->category->name);
        // 渲染页面
        $this->render('index', [
            'category' => $this->category,
            'model' => $model,
        ]);
    }

    /**
     * 重置表单配置，其实就是删除或清理 pub_form_setting 的内容
     * @throws \Exception
     */
    public function actionReset()
    {
        $model = new FormSetting($this->category->key);

        if ($model->reset()) {
            $this->success($this->category->name . '重置成功', -1);
        } else {
            $this->failure($this->category->name . '重置失败', $model->getErrors());
        }
    }
}