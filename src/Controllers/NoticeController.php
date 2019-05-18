<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use Admin\Components\Controller;
use Admin\Components\Log;
use Admin\Models\Notice;
use DbSupports\Builder\Criteria;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-14
 * Version      :   1.0
 */
class NoticeController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var string nav标记 */
    public $navFlag = 'setting';

    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_NOTICE;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     */
    protected function beforeAction($action)
    {
        return true;
    }

    /**
     * 默认action
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $fixer = $this->getActionParams();
        $model = new Notice();
        $criteria = new Criteria();

        if (isset($fixer['is_publish']) && '' !== $fixer['is_publish']) {
            $criteria->addWhere('`is_publish`=:is_publish')
                ->addParam(':is_publish', $fixer['is_publish']);
        }
        if (isset($fixer['start_time']) && '' !== $fixer['start_time']) {
            $criteria->addWhere('`publish_time`>:start_time')
                ->addParam(':start_time', $fixer['start_time']);
        }
        if (isset($fixer['end_time']) && '' !== $fixer['end_time']) {
            $criteria->addWhere('`publish_time`>:end_time')
                ->addParam(':end_time', $fixer['end_time']);
        }
        if (isset($fixer['keyword']) && '' !== $fixer['keyword']) {
            $criteria->addWhereLike('`subject`', $fixer['keyword']);
        }
        // 模型分页查询
        $pager = (new Notice())->pagination($criteria, true);
        // 设置页面标题
        $this->setPageTitle('公告列表');
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 添加公告
     * @throws \Exception
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new Notice();
        // 表单提交处理
        if (isset($_POST['Notice'])) {
            $model->setAttributes($_POST['Notice']);
            $this->logMessage = '添加公告';
            $this->logKeyword = $model->subject;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('添加公告成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('添加公告');
        // 渲染页面
        $this->render('add', [
            'model' => $model,
        ]);
    }

    /**
     * 编辑公告
     * @throws \Exception
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['Notice'])) {
            $model->setAttributes($_POST['Notice']);
            $this->logMessage = '编辑公告';
            $this->logKeyword = $model->subject;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑公告成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑公告信息');
        // 渲染页面
        $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * 查看区块类型信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看公告信息');
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 删除公告
     * @throws \Exception
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        $this->logMessage = '删除公告';
        $this->logKeyword = $model->subject;
        if ($model->delete()) {
            $this->logData = $model->getAttributes();
            $this->success('删除公告成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 获取操作模型
     * @return \Abstracts\DbModel|Notice|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = Notice::model()->findByPk($this->getActionParam('id'));
        /* @var Notice $model */
        if (null === $model) {
            $this->throwHttpException(404, '公告不存在');
        }
        return $model;
    }
}