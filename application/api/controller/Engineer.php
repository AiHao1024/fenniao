<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

/**
 * 工程师
 */
class Engineer extends Api
{
    protected $noNeedLogin = ['index','engineer_flow','engineer_like'];
    protected $noNeedRight = ['engineer_sign'];

    /**
     * 工程师列表
     *
     * @ApiParams   (name="page", type="integer", required=true, description="页码")
     * @ApiParams   (name="name", type="integer", required=true, description="搜索词")
     * @ApiReturnParams (name="name", type="string", required=true, description="名字")
     * @ApiReturnParams (name="score", type="string", required=true, description="评分")
     * @ApiReturnParams (name="sort", type="string", required=true, description="sort")
     * @ApiReturnParams (name="avater_image", type="string", required=true, description="头像")
     * @ApiReturnParams (name="detail", type="string", required=true, description="介绍")
     * @ApiReturnParams (name="order_num", type="string", required=true, description="订单数")
     */
    public function index()
    {
        $limit=9;
        $sort='sort';
        $name=$this->request->request('name');
        $page = $this->request->request('page');
        if($name){
            $data=Db::name('engineer_list')->where('name|detail','like','%'.$name.'%')->select();
        }else{
            $data=Db::name('engineer_list')->where('status','normal')->page($page,$limit)->order($sort.' desc')->select();
        }
        $data2=Db::name('engineer_list')->where('status','normal')->select();
        $count=count($data2);
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success($count, $data);
    }

    /**
     * 工程师流程图
     *
     */
    public function engineer_flow()
    {
        $data=Db::name('engineer_flow')->select();
        $this->success(__('查找成功'), $data);
    }



    /**
     * 工程师注册
     *
     * @ApiParams   (name="name", type="integer", required=true, description="名字")
     * @ApiParams   (name="avater_image", type="integer", required=true, description="头像")
     * @ApiParams   (name="detail", type="integer", required=true, description="介绍")
     */
    public function engineer_sign()
    {
        $user_id=$this->auth->id;
        $is_set=Db::name('engineer_list')->where('user_id',$user_id)->find();
        if($is_set){
            $this->error(__('已报名，请勿重复提交'));
        }
        $name = $this->request->request('name');
        $avater_image = $this->request->request('avater_image');
        $detail = $this->request->request('detail');
        $create_time=time();
        if(!$name || !$avater_image || !$detail  ){
            $this->error(__('参数缺失'));
        }
        $data=['user_id'=>$user_id,'name'=>$name,'avater_image'=>$avater_image,'detail'=>$detail,'create_time'=>$create_time,'status'=>'finish'];
        $result=Db::name('engineer_list')->insert($data);
        if($result){
            $this->success(__('添加成功'), $result);
        }else{
            $this->error(__('添加失败'));
        }

    }


}