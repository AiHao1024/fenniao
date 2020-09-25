<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

  
      /**
     * 轮播图详情
     *
     * @param string $id  ID
     */
    public function banner_detail()
    {
        $id = $this->request->request('id');
        $data=Db::name('banner')->where('Id',$id)->find();
        $this->success(__('查找成功'), $data);
    }

    /**
     * 轮播图
     *
     */
    public function banner()
    {
        $data=Db::name('banner')->select();
        $this->success(__('查找成功'), $data);
    }

    /**
     * 公司信息概论
     *
     */
    public function company()
    {
        $data=Db::name('company')->select();
        $this->success(__('查找成功'), $data);
    }

    /**
     * 滚动订单
     *
     * @ApiReturnParams (name="ordersn", type="string", required=true, description="订单号")
     * @ApiReturnParams (name="name", type="string", required=true, description="订单名称")
     * @ApiReturnParams (name="form_image", type="string", required=true, description="提交的表格")
     * @ApiReturnParams (name="drawing_image", type="string", required=true, description="提交的图纸")
     * @ApiReturnParams (name="pay_image", type="string", required=true, description="支付凭证")
     * @ApiReturnParams (name="detail", type="string", required=true, description="订单详情")
     * @ApiReturnParams (name="create_time", type="string", required=true, description="创建时间")
     * @ApiReturnParams (name="money", type="string", required=true, description="订单金额")
     * @ApiReturnParams (name="construction_image", type="string", required=true, description="施工流程图")
     * @ApiReturnParams (name="invoice_image", type="string", required=true, description="发票")
     * @ApiReturnParams (name="status", type="string", required=true, description="examin=审核中，reply=待回复，confirm=已确认，unpaid=未支付，conduct=进行中，finish=已完成")
     * @ApiReturnParams (name="classification", type="string", required=true, description="订单分类 1：产品定制 2：样品制造")
     * @ApiReturnParams (name="process", type="string", required=true, description="制造进度examin=审核中，confirm=已确认，conduct=进行中，finish=已完成")
     * @ApiReturnParams (name="is_invoice", type="string", required=true, description="是否开票 0：未开 1已开")
     * @ApiReturnParams (name="problem", type="string", required=true, description="项目问题")
     * @ApiReturnParams (name="is_evaluate", type="string", required=true, description="是否评价 0未评价 1已评价")
     */
    public function order()
    {
        $data=Db::name('manufacture_order')->order('id desc')->select();
           foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success(__('查找成功'), $data);
    }

    /**
     * 新闻中心
     *
     * @ApiParams   (name="type", type="integer", required=true, description="新闻类型 1：行业新闻 2公司动态 0：全部")
     * @ApiParams   (name="page", type="integer", required=true, description="页码 每页10条数据")
     */
    public function news()
    {
        $limit=4;
        $type = $this->request->request('type');
        $page = $this->request->request('page');
        $data=Db::name('news')->page($page,$limit)->order('id desc')->select();
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success(__('查找成功'), $data);
    }
  
     /**
     * 新闻详情
     *
     * @param string $id  ID
     */
    public function news_detail()
    {
        $id = $this->request->request('id');
        $data=Db::name('news')->where('id',$id)->find();
        $this->success(__('查找成功'), $data);
    }


    /**
     * 合作商
     *
     */
    public function partner()
    {
        $data=Db::name('partner')->where('status','normal')->select();
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success(__('查找成功'), $data);
    }
  
      /**
     * 申请成为合作商
     *
     *@param string $name  名字
     *@param string $href  链接
     *@param string $image  图片地址
     */
    public function apply_partner()
    {
        $name = $this->request->request('name');
        $href = $this->request->request('href');
        $image = $this->request->request('image');
        if (!$name || !$href || !$image) {
            $this->error(__('Invalid parameters'));
        }
        $data=['name'=>$name,'href'=>$href,'image'=>$image,'create_time'=>time(),'status'=>'reviewed'];
        Db::name('partner')->insert($data);
        $this->success(__('申请成功'), $data);
    }

    /**
     * 公司信息
     *
     */
    public function company_news()
    {
        $data=Db::name('company_news')->find();
        $this->success(__('查找成功'), $data);
    }


    /**
     * 备案信息
     *
     */
    public function keep_record()
    {
        $data=Db::name('config')->where('name','beian')->field('value')->find();
        $this->success(__('查找成功'), $data);
    }




}
