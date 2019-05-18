<?php
// 申明命名空间
namespace Admin\Controllers;

// 引用类
use Admin\Components\Controller;
use Admin\Components\Pub;
use Helper\FileManager;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-18
 * Version      :   1.0
 */
class FlushController extends Controller
{
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
     * 清理缓存
     * @throws \Exception
     */
    public function actionRuntime()
    {
        $dp = opendir(RUNTIME_PATH);
        while ($fp = readdir($dp)) {
            if ('.' === $fp || '..' === $fp) {
                continue;
            }
            $file = RUNTIME_PATH . '/' . $fp;
            if (is_file($file)) {
                continue;
            }
            FileManager::rmdir($file, true);
        }
        closedir($dp);
        $this->output('清理成功');
    }
}