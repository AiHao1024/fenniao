<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;

/**
 * 学院实训中心
 */
class Student extends Api
{
    protected $noNeedLogin = ['training_list','student_case','student_base','review','training_fenlei','training_detail','review_detail'];
    protected $noNeedRight = ['school_sign'];

    /**
     * 实训项目分类
     *
     */
    public function training_fenlei()
    {
        $data=Db::name('training_fenlei')->select();
        $this->success(__('查找成功'), $data);
    }


    /**
     * 实训项目列表
     *
     * @ApiParams   (name="t_id", type="integer", required=true, description="分类ID")
     * @ApiReturnParams (name="t_id", type="string", required=true, description="分类Id")
     * @ApiReturnParams (name="title", type="string", required=true, description="标题")
     * @ApiReturnParams (name="subtitle", type="string", required=true, description="副标题")
     * @ApiReturnParams (name="detail", type="string", required=true, description="详情")
     * @ApiReturnParams (name="create_time", type="string", required=true, description="创建时间")
     */
    public function training_list()
    {
        $t_id = $this->request->request('t_id');
        $data=Db::name('training_list')->where('t_id',$t_id)->select();
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success(__('查找成功'), $data);
    }

    /**
     * 实训项目详情
     *
     * @ApiParams   (name="id", type="integer", required=true, description="ID")
     * @ApiReturnParams (name="t_id", type="string", required=true, description="分类Id")
     * @ApiReturnParams (name="title", type="string", required=true, description="标题")
     * @ApiReturnParams (name="subtitle", type="string", required=true, description="副标题")
     * @ApiReturnParams (name="detail", type="string", required=true, description="详情")
     * @ApiReturnParams (name="create_time", type="string", required=true, description="创建时间")
     */
    public function training_detail()
    {
        $id = $this->request->request('id');
        $data=Db::name('training_list')->where('id',$id)->select();
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success(__('查找成功'), $data);
    }


    /**
     * 学员案例列表
     *
     * @ApiParams   (name="page", type="integer", required=true, description="页码 每页6条数据")
     */
    public function student_case()
    {
        $limit=6;
        $page = $this->request->request('page');
        $count=Db::name('student_case')->count();
        $data=Db::name('student_case')->page($page,$limit)->select();
        $this->success($count, $data);
    }

    /**
     * 实训基地信息
     *
     */
    public function student_base()
    {
        $data=Db::name('student_base')->select();
        $this->success(__('查找成功'), $data);
    }


    /**
     * 往期活动列表
     *
     * @ApiParams   (name="page", type="integer", required=true, description="页码 每页10条数据")
     * @ApiParams   (name="ago", type="integer", required=true, description="几个月前，传1，2直接值")
     */
    public function review()
    {
        $limit=4;
        $page = $this->request->request('page');
        $ago = $this->request->request('ago');
        if(!$page || !$ago){
            $this->error(__('参数缺失'));
        }
        $mothtime=strtotime( '-'.$ago."month");
        $count=Db::name('review')->count();
        $data=Db::name('review')->page($page,$limit)->where('create_time'.'<'.$mothtime)->select();
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success($count, $data);
    }

    /**
     * 往期活动详情
     *
     * @ApiParams   (name="id", type="integer", required=true, description="ID")
     */
    public function review_detail()
    {
        $id = $this->request->request('id');
        $data=Db::name('review')->where('id',$id)->select();
        foreach ($data as $key=>$value){
            $data[$key]['create_time']=date('Y-m-d',$value['create_time']);
        }
        $this->success(__('查找成功'), $data);
    }


    /**
     * 学员报名
     *
     * @ApiParams   (name="name", type="integer", required=true, description="名字")
     * @ApiParams   (name="school_name", type="integer", required=true, description="学校名")
     * @ApiParams   (name="email", type="integer", required=true, description="邮箱")
     * @ApiParams   (name="phone", type="integer", required=true, description="电话")
     * @ApiParams   (name="major", type="integer", required=true, description="专业")
     */
    public function school_sign()
    {
        $user_id=$this->auth->id;
        $is_set=Db::name('school_sign')->where('user_id',$user_id)->find();
        if($is_set){
            $this->error(__('已报名，请勿重复提交'));
        }
        $name = $this->request->request('name');
        $school_name = $this->request->request('school_name');
        $email = $this->request->request('email');
        $phone = $this->request->request('phone');
        $major = $this->request->request('major');
        $create_time=time();
        if(!$name || !$school_name || !$email || !$phone || !$major ){
            $this->error(__('参数缺失'));
        }
        $data=['user_id'=>$user_id,'name'=>$name,'school_name'=>$school_name,'email'=>$email,'email'=>$email,'phone'=>$phone,'major'=>$major,'create_time'=>$create_time];
        $result=Db::name('school_sign')->insert($data);
        if($result){
            $this->success(__('添加成功'), $result);
        }else{
            $this->error(__('添加失败'));
        }

    }


}
