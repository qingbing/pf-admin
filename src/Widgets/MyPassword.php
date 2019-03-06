<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-06
 * Version      :   1.0
 */

namespace Admin\Widgets;


use Abstracts\OutputCache;

class MyPassword extends OutputCache
{
    /**
     * 在 @link init() 之前运行
     * @return string
     */
    protected function generateId()
    {
        return 'admin.widget.MyPassword';
    }

    /**
     * 构建 cache-content ： 在 @link init() 之后运行
     * @return mixed|void
     * @throws \Exception
     */
    protected function generateContent()
    {
        $url = $this->createUrl('/admin/ajax/validMyPassword');
        echo <<<EDO
<dl class="form-group row">
    <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label for="myPassword">人员确认密码</label>：</dt>
    <dd class="col-md-6 col-sm-6 col-lg-6">
        <input type="text" name="myPassword" id="myPassword" class="form-control" autocomplete="off" onfocus="this.type='password'"
            data-allow-empty="false" data-ajax-url="{$url}" data-tip-msg="请输入个人登录密码" 
            data-empty-msg="个人登录密码不能为空" data-valid-type="password" data-help-block="#help-block_myPassword"></dd>
    <dd class="col-sm-3 col-md-3 col-lg-3 text-left" id="help-block_myPassword"></dd>
</dl>

EDO;
    }
}