<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Components;


class Controller extends \Render\Abstracts\Controller
{
    /* @var string nav标记 */
    public $navFlag = 'home';

    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = false;
    /* @var string 日志类型 */
    protected $logType;
    /* @var string 日志消息 */
    protected $logMessage;
    /* @var mixed 日志关键字 */
    protected $logKeyword = '';
    /* @var mixed 记录的日志辅助内容 */
    protected $logData;

    /**
     * 设置页面标题
     * @param $title
     */
    protected function setPageTitle($title)
    {
        $this->setClip('title', $title);
    }

    /**
     * 操作失败
     * @param string $errorMsg
     * @param array $errData
     * @param int $errorCode
     * @param string $url
     * @throws \Exception
     */
    protected function failure($errorMsg = '', $errData = [], $errorCode = -1, $url = '')
    {
        if ($this->openLog) {
            $logData = $this->logData ? $this->logData : $errData;
            Log::getInstance()->operate(false, $this->logType, $this->logMessage, $this->logKeyword, $logData);
        }
        if (empty($errorMsg)) {
            $errorMsg = $this->error2string($errData);
        }
        parent::failure($errorMsg, $errData, $errorCode, $url);
    }

    /**
     * 操作成功
     * @param string $msg
     * @param string $url
     * @param array $data
     * @throws \Exception
     */
    protected function success($msg = '', $url = '', $data = [])
    {
        if ($this->openLog) {
            $logData = $this->logData ? $this->logData : $data;
            Log::getInstance()->operate(true, $this->logType, $this->logMessage, $this->logKeyword, $logData);
        }
        parent::success($msg, $url, $data);
    }

    /**
     * 将错误消息字符串
     * @param $array
     * @param string $space
     * @return string
     */
    protected function error2string($array, $space = '')
    {
        if (is_array($array)) {
            $r = "";
            foreach ($array as $var) {
                if (is_array($var)) {
                    $r .= $this->error2string($var, $space . "\t") . "\n";
                } else {
                    $r .= $space . $var . "\n";
                }
            }
            return $r;
        }
        return $array;
    }
}