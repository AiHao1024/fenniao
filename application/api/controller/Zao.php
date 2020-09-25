<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

/**
 * 蜂鸟造接口
 */
class Zao extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];


    /**
     * 公司优势
     *
     */
    public function company_advantages()
    {
        $data=Db::name('company_advantages')->select();
        $this->success(__('查找成功'), $data);
    }

    /**
     * 公司简介
     * @ApiReturnParams (name="content", type="string", required=true, description="内容")
     * @ApiReturnParams (name="found", type="string", required=true, description="创立时间")
     * @ApiReturnParams (name="introduction", type="string", required=true, description="数据简介")
     * @ApiReturnParams (name="time_introduction", type="string", required=true, description="时间简介")
     * @ApiReturnParams (name="num", type="string", required=true, description="数量简介")
     */
    public function company_profile()
    {
        $data=Db::name('company_profile')->select();
        $this->success(__('查找成功'), $data);
    }

    /**
     * 产品展示
     *
     */
    public function company_products()
    {
        $data=Db::name('company_products')->select();
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success(__('查找成功'), $data);
    }





}
