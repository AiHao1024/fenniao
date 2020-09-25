<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

/**
 * 订单接口
 */
class Order extends Api
{
    protected $noNeedLogin = [];
    protected $noNeedRight = ['order_list','order_like','is_invoice','order_evaluate','look__evaluate','place_order'];


    /**
     * 订单列表
     *
     * @ApiParams   (name="page", type="integer", required=true, description="页码 每页10条数据")
     * @ApiParams   (name="limit", type="integer", required=true, description="条数")
     * @ApiParams   (name="status", type="integer", required=true, description="状态值：examin=审核中，reply=待回复，confirm=已确认，unpaid=未支付，conduct=进行中，finish=已完成")
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
    public function order_list()
    {
        $limit=$this->request->request('limit');
        $page = $this->request->request('page');
        $status = $this->request->request('status');
        if(!$page || !$status){
            $this->error(__('参数缺失'));
        }
        $user_id=$this->auth->id;
        $count=Db::name('manufacture_order')->where(['user_id'=>$user_id,'status'=>$status])->count();
        $data=Db::name('manufacture_order')->where(['user_id'=>$user_id,'status'=>$status])->page($page,$limit)->select();
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success($count, $data);
    }


    /**
     * 下单
     *
     * @ApiParams   (name="name", type="integer", required=true, description="订单名称")
     * @ApiParams   (name="company_name", type="integer", required=true, description="公司名称")
     * @ApiParams   (name="phone", type="integer", required=true, description="联系电话")
     * @ApiParams   (name="product_type", type="integer", required=true, description="类型")
     * @ApiParams   (name="form_image", type="string", required=true, description="提交的表格")
     * @ApiParams   (name="drawing_image", type="string", required=true, description="提交的图纸")
     * @ApiParams   (name="classification", type="string", required=true, description="订单分类：1：产品定制 2：样品制造")
     */

    public function place_order(){
        $user_id=$this->auth->id;
        $name=$this->request->request('name');
        $company_name=$this->request->request('company_name');
        $phone=$this->request->request('phone');
        $product_type=$this->request->request('product_type');
        $form_image=$this->request->request('form_image');
        $drawing_image=$this->request->request('drawing_image');
        $classification=$this->request->request('classification');
        $create_time=time();
        $order_sn=$this->getordersn();
        if(!$name || !$company_name || !$phone|| !$product_type|| !$form_image|| !$drawing_image|| !$classification){
            $this->error(__('参数缺失'));
        }
        $data=['user_id'=>$user_id,'name'=>$name,'company_name'=>$company_name,'phone'=>$phone,'product_type'=>$product_type,'form_image'=>$form_image,'drawing_image'=>$drawing_image,'ordersn'=>$order_sn,'classification'=>$classification,'create_time'=>$create_time];
        $a=Db::name('manufacture_order')->insert($data);
        if ($a){
            $this->success(__('添加成功'), $data);
        }else{
            $this->error('添加失败');
        }
    }




    /**
     * 查找订单
     *
     * @ApiParams   (name="name", type="integer", required=true, description="订单名称或者订单号")
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
    public function order_like()
    {
        $name=$this->request->request('name');
        $data=Db::name('manufacture_order')->where('name|ordersn','like','%'.$name.'%')->select();
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success(__('查找成功'), $data);
    }

    /**
     * 订单评价
     *
     * @ApiParams   (name="id", type="integer", required=true, description="订单ID")
     * @ApiParams   (name="content", type="integer", required=true, description="订单评价详情")
     */
    public function order_evaluate()
    {
        $id=$this->request->request('id');
        $content=$this->request->request('content');
        $time=time();
        $order=Db::name('manufacture_order')->where('id',$id)->find();
        if($order['is_evaluate']==0){
            $data=['order_id'=>$id,'content'=>$content,'create_time'=>$time];
            $a=Db::name('order_evaluate')->insert($data);
            $b=Db::name('manufacture_order')->where('id',$id)->update(['is_evaluate'=>1]);
            $this->success(__('评价成功'), 1);
        }else{
            $this->error('订单已评价');
        }
    }

    /**
     * 查看订单评价
     *
     * @ApiParams   (name="id", type="integer", required=true, description="订单ID")
     */
    public function look__evaluate(){
        $id=$this->request->request('id');
        $data=Db::name('order_evaluate')->where(['order_id'=>$id])->find();
        $this->success(__('查找成功'), $data);
    }

    /**
     * 开票订单列表
     *
     * @ApiParams   (name="is_invoice", type="integer", required=true, description="是否开票 0：未开 1已开")
     * @ApiParams   (name="page", type="integer", required=true, description="页码 每页10条数据")
     * @ApiParams   (name="limit", type="integer", required=true, description="条数")
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
    public function is_invoice()
    {
        $page = $this->request->request('page');
        $limit = $this->request->request('limit');
        $is_invoice = $this->request->request('is_invoice');
        $user_id=$this->auth->id;
        $count=Db::name('manufacture_order')->where(['user_id'=>$user_id,'status'=>'finish','is_invoice'=>$is_invoice])->count();
        $data=Db::name('manufacture_order')->where(['user_id'=>$user_id,'status'=>'finish','is_invoice'=>$is_invoice])->page($page,$limit)->select();
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success($count, $data);

    }

    /**
     * 客户回复问题
     *
     * @ApiParams   (name="id", type="integer", required=true, description="订单ID")
     * @ApiParams   (name="detail", type="integer", required=true, description="回复内容")
     */
    public function reply(){
        $id=$this->request->request('id');
        $detail=$this->request->request('detail');
        $data=Db::name('manufacture_order')->where(['id'=>$id])->update(['detail'=>$detail]);
        $this->success(__('回复成功'), $data);
    }

    /**
     * 客户上传支付凭证
     *
     * @ApiParams   (name="id", type="integer", required=true, description="订单ID")
     * @ApiParams   (name="pay_image", type="integer", required=true, description="支付凭证")
     */
    public function pay_image(){
        $id=$this->request->request('id');
        $pay_image=$this->request->request('pay_image');
        $data=Db::name('manufacture_order')->where(['id'=>$id])->update(['pay_image'=>$pay_image]);
        $this->success(__('上传成功'), $data);
    }


    //生成订单号
    function getordersn(){
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;

    }

}