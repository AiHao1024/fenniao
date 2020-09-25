<?php

namespace app\admin\model;

use think\Model;


class ManufactureOrder extends Model
{

    

    

    // 表名
    protected $name = 'manufacture_order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'create_time_text',
        'status_text',
        'process_text'
    ];
    

    
    public function getStatusList()
    {
        return ['examin' => __('Examin'), 'reply' => __('Reply'), 'confirm' => __('Confirm'), 'unpaid' => __('Unpaid'), 'conduct' => __('Conduct'), 'finish' => __('Finish')];
    }

    public function getProcessList()
    {
        return ['examin' => __('Examin'), 'confirm' => __('Confirm'), 'conduct' => __('Conduct'), 'finish' => __('Finish')];
    }


    public function getCreateTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['create_time']) ? $data['create_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getProcessTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['process']) ? $data['process'] : '');
        $list = $this->getProcessList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setCreateTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

    public function fenlei()
    {
        return $this->belongsTo('Fenlei', 'classification', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
