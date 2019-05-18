<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-05-18
 * Version      :   1.0
 */

namespace Admin\Components;


use Abstracts\SingleTon;

class NavSetting extends SingleTon
{
    private $_navs = [];

    /**
     * @throws \Exception
     */
    protected function init()
    {
        $this->addNav('home', '首页', [
            '/personal/index',
        ]);
        $this->addNav('setting', '网站配置', [
            '/nav/index',
        ]);
    }

    /**
     * @param string $flag
     * @param string $label
     * @param mixed $url
     * @throws \Exception
     */
    protected function addNav($flag, $label, $url)
    {
        if (is_array($url)) {
            $url = Pub::getModule()->createUrl(array_shift($url), $url);
        }
        array_push($this->_navs, [
            'flag' => $flag,
            'label' => $label,
            'url' => $url,
        ]);
    }

    /**
     * 返回最终的nav配置数组
     * @return array
     * @throws \Exception
     */
    final public function getNavs()
    {
        return $this->_navs;
    }
}