<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

/**
 * 快速制造中心
 */
class Manufacture extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 产品定制分类
     *
     */
    public function product_classification()
    {
        $data=Db::name('product_classification')->select();
        $this->success(__('查找成功'), $data);
    }


    /**
     * 样品制造分类
     *
     */
    public function sample_classification()
    {
        $data=Db::name('sample_classification')->select();
        $this->success(__('查找成功'), $data);
    }
}