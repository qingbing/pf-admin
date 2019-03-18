<?php
// 申明命名空间
namespace Admin\Controllers;
// 引用类
use Admin\Components\Controller;
use Admin\Components\Log;
use Admin\Components\Pub;
use Admin\Models\BlockCategory;
use DbSupports\Builder\Criteria;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-18
 * Version      :   1.0
 */
class BlockCateController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_BLOCK;

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
        return true;
    }

    /**
     * 默认action : 区块类型列表
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $fixer = $this->getActionParams();
        $criteria = new Criteria();
        // 只显示开放的类型
        $criteria->addWhere('`is_open`=:is_open')
            ->addParam(':is_open', 1);

        if (isset($fixer['type']) && '' !== $fixer['type']) {
            $criteria->addWhere('`type`=:type')
                ->addParam(':type', $fixer['type']);
        }
        if (isset($fixer['keyword']) && '' !== $fixer['keyword']) {
            $criteria->addWhereLike('`name`', $fixer['keyword']);
        }

        // 模型分页查询
        $pager = (new BlockCategory())->pagination($criteria, true);
        // 设置页面标题
        $this->setPageTitle('区块类型');
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 查看区块信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看区块类型信息');
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 查看区块类型信息
     * @throws \Exception
     */
    public function actionContent()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['BlockCategory'])) {
            $this->logMessage = '编辑区块内容';
            $model->setAttributes($_POST['BlockCategory']);
            $this->logKeyword = $model->key;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑区块内容成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑区块内容');
        // 渲染页面
        $this->render('content', [
            'model' => $model,
        ]);
    }

    /**
     * 获取操作区块类型
     * @return \Abstracts\DbModel|BlockCategory|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = BlockCategory::model()->findByPk($this->getActionParam('key'));
        /* @var BlockCategory $model */
        if (null === $model) {
            $this->throwHttpException(404, '区块不存在');
        }
        if (!$model->is_open) {
            $this->throwHttpException(403, '对不起，您无权操作该内容');
        }
        return $model;
    }
}