<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:95:"/www/wwwroot/fengniao.hkzhtech.com/public/../application/admin/view/manufacture_order/edit.html";i:1601019019;s:77:"/www/wwwroot/fengniao.hkzhtech.com/application/admin/view/layout/default.html";i:1588765310;s:74:"/www/wwwroot/fengniao.hkzhtech.com/application/admin/view/common/meta.html";i:1588765310;s:76:"/www/wwwroot/fengniao.hkzhtech.com/application/admin/view/common/script.html";i:1588765310;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('User_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-user_id" data-rule="required" data-source="user/user/index" data-field="nickname" class="form-control selectpage" name="row[user_id]" type="text" value="<?php echo htmlentities($row['user_id']); ?>" readOnly="true">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Ordersn'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-ordersn" class="form-control" name="row[ordersn]" type="text" value="<?php echo htmlentities($row['ordersn']); ?>" readOnly="true">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" class="form-control" name="row[name]" type="text" value="<?php echo htmlentities($row['name']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Classification'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-classification" data-rule="required" data-source="fenlei/index" class="form-control selectpage" name="row[classification]" type="text" value="<?php echo htmlentities($row['classification']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Product_type'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <?php if(($row['classification']==1)): ?>
            <input id="c-product_type" data-rule="required" data-source="product_classification/index" class="form-control selectpage" name="row[product_type]" type="text" value="<?php echo htmlentities($row['product_type']); ?>">
            <?php else: ?>
            <input id="c-product_type" data-rule="required" data-source="sample_classification/index" class="form-control selectpage" name="row[product_type]" type="text" value="<?php echo htmlentities($row['product_type']); ?>">
            <?php endif; ?>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Form_image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-form_image" class="form-control" size="50" name="row[form_image]" type="text" value="<?php echo htmlentities($row['form_image']); ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-form_image" class="btn btn-danger plupload" data-input-id="c-form_image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-form_image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-form_image" class="btn btn-primary fachoose" data-input-id="c-form_image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-form_image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-form_image"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Drawing_image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-drawing_image" class="form-control" size="50" name="row[drawing_image]" type="text" value="<?php echo htmlentities($row['drawing_image']); ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-drawing_image" class="btn btn-danger plupload" data-input-id="c-drawing_image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-drawing_image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-drawing_image" class="btn btn-primary fachoose" data-input-id="c-drawing_image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-drawing_image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-drawing_image"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Pay_image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-pay_image" class="form-control" size="50" name="row[pay_image]" type="text" value="<?php echo htmlentities($row['pay_image']); ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-pay_image" class="btn btn-danger plupload" data-input-id="c-pay_image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-pay_image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-pay_image" class="btn btn-primary fachoose" data-input-id="c-pay_image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-pay_image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-pay_image"></ul>
        </div>
    </div>
        <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2">项目问题:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-problem" class="form-control " rows="5" name="row[problem]" cols="50"><?php echo htmlentities($row['problem']); ?></textarea>
        </div>
    </div>
        <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Detail'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-detail" class="form-control " rows="5" name="row[detail]" cols="50"><?php echo htmlentities($row['detail']); ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Create_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-create_time" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[create_time]" type="text" value="<?php echo $row['create_time']?datetime($row['create_time']):''; ?>" readOnly="true">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Money'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-money" class="form-control" step="0.01" name="row[money]" type="number" value="<?php echo htmlentities($row['money']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Construction_image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-construction_image" class="form-control" size="50" name="row[construction_image]" type="text" value="<?php echo htmlentities($row['construction_image']); ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-construction_image" class="btn btn-danger plupload" data-input-id="c-construction_image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-construction_image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-construction_image" class="btn btn-primary fachoose" data-input-id="c-construction_image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-construction_image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-construction_image"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Invoice_image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-invoice_image" class="form-control" size="50" name="row[invoice_image]" type="text" value="<?php echo htmlentities($row['invoice_image']); ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-invoice_image" class="btn btn-danger plupload" data-input-id="c-invoice_image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-invoice_image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-invoice_image" class="btn btn-primary fachoose" data-input-id="c-invoice_image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-invoice_image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-invoice_image"></ul>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
            <label for="row[status]-<?php echo $key; ?>"><input id="row[status]-<?php echo $key; ?>" name="row[status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['status'])?$row['status']:explode(',',$row['status']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Process'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-process" class="form-control selectpicker" name="row[process]">
                <?php if(is_array($processList) || $processList instanceof \think\Collection || $processList instanceof \think\Paginator): if( count($processList)==0 ) : echo "" ;else: foreach($processList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['process'])?$row['process']:explode(',',$row['process']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <!--<div class="form-group">-->
    <!--    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Is_invoice'); ?>:</label>-->
    <!--    <div class="col-xs-12 col-sm-8">-->
    <!--        <input id="c-is_invoice" class="form-control" name="row[is_invoice]" type="number" value="<?php echo htmlentities($row['is_invoice']); ?>">-->
    <!--    </div>-->
    <!--</div>-->
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>