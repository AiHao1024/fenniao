define([], function () {
    if (Config.editpage.app_debug == true) {
    require.config({
        paths: {
            ace: ['../addons/editpage/js/ace'],
            tools: ['../addons/editpage/js/ext-language_tools']
        }
    });
    if (Config.editpage.module == 'admin' && ['editpage', 'index'].indexOf(Config.editpage.controller.toLowerCase()) == -1) {
        //浮动按钮
        var _html = '<div id="editpage" style="position: fixed;right: 0;top: 20%;z-index: 999;flex-flow: column;right: 5px;">' +
            '<a style="display: flex;margin-bottom: 2px;" href="javascript:;" data-type="c" class="btn btn-primary" title="控制器">C</a>' +
            '<a style="display: flex;margin-bottom: 2px;" href="javascript:;" data-type="m" class="btn btn-info" title="模型">M</a>' +
            '<a style="display: flex;margin-bottom: 2px;" href="javascript:;" data-type="v" class="btn btn-success" title="视图">V</a>' +
            '<a style="display: flex;margin-bottom: 2px;" href="javascript:;" data-type="j" class="btn btn-danger" title="JS">J</a>' +
            '<a style="display: flex;margin-bottom: 2px;" href="javascript:;" data-type="l" class="btn btn-warning" title="Lang">L</a>' +
            '<a style="display: flex;margin-bottom: 2px;" href="javascript:;" data-type="command" class="btn btn-primary" title="命令行">&lt;</a>' +
            '</div>';
        $("body").append(_html);
        //触发弹窗
        $('#editpage').find('a').click(function () {
            var title = $(this).attr('title');
            var type = $(this).attr('data-type');
            if(type == 'command'){
                var url = Config.editpage.command;
            }else{
                var url = Config.editpage.index + '?module=' + Config.editpage.module + '&c=' + Config.editpage.controller + '&a=' + Config.editpage.action + '&type=' + type;
            }
            parent.Fast.api.open(url, title, {area: ["80%", "80%"]});
        });
    }
}

require.config({
    paths: {
        'async': '../addons/example/js/async',
        'BMap': ['//api.map.baidu.com/api?v=2.0&ak=mXijumfojHnAaN2VxpBGoqHM'],
    },
    shim: {
        'BMap': {
            deps: ['jquery'],
            exports: 'BMap'
        }
    }
});

require.config({
    paths: {
        'summernote': '../addons/summernote/lang/summernote-zh-CN.min'
    },
    shim: {
        'summernote': ['../addons/summernote/js/summernote.min', 'css!../addons/summernote/css/summernote.css'],
    }
});
require(['form', 'upload'], function (Form, Upload) {
    var _bindevent = Form.events.bindevent;
    Form.events.bindevent = function (form) {
        _bindevent.apply(this, [form]);
        try {
            //绑定summernote事件
            if ($(".summernote,.editor", form).size() > 0) {
                require(['summernote'], function () {
                    var imageButton = function (context) {
                        var ui = $.summernote.ui;
                        var button = ui.button({
                            contents: '<i class="fa fa-file-image-o"/>',
                            tooltip: __('Choose'),
                            click: function () {
                                parent.Fast.api.open("general/attachment/select?element_id=&multiple=true&mimetype=image/*", __('Choose'), {
                                    callback: function (data) {
                                        var urlArr = data.url.split(/\,/);
                                        $.each(urlArr, function () {
                                            var url = Fast.api.cdnurl(this);
                                            context.invoke('editor.insertImage', url);
                                        });
                                    }
                                });
                                return false;
                            }
                        });
                        return button.render();
                    };
                    var attachmentButton = function (context) {
                        var ui = $.summernote.ui;
                        var button = ui.button({
                            contents: '<i class="fa fa-file"/>',
                            tooltip: __('Choose'),
                            click: function () {
                                parent.Fast.api.open("general/attachment/select?element_id=&multiple=true&mimetype=*", __('Choose'), {
                                    callback: function (data) {
                                        var urlArr = data.url.split(/\,/);
                                        $.each(urlArr, function () {
                                            var url = Fast.api.cdnurl(this);
                                            var node = $("<a href='" + url + "'>" + url + "</a>");
                                            context.invoke('insertNode', node[0]);
                                        });
                                    }
                                });
                                return false;
                            }
                        });
                        return button.render();
                    };

                    $(".summernote,.editor", form).summernote({
                        height: 250,
                        lang: 'zh-CN',
                        fontNames: [
                            'Arial', 'Arial Black', 'Serif', 'Sans', 'Courier',
                            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande',
                            "Open Sans", "Hiragino Sans GB", "Microsoft YaHei",
                            '微软雅黑', '宋体', '黑体', '仿宋', '楷体', '幼圆',
                        ],
                        fontNamesIgnoreCheck: [
                            "Open Sans", "Microsoft YaHei",
                            '微软雅黑', '宋体', '黑体', '仿宋', '楷体', '幼圆'
                        ],
                        toolbar: [
                            ['style', ['style', 'undo', 'redo']],
                            ['font', ['bold', 'underline', 'strikethrough', 'clear']],
                            ['fontname', ['color', 'fontname', 'fontsize']],
                            ['para', ['ul', 'ol', 'paragraph', 'height']],
                            ['table', ['table', 'hr']],
                            ['insert', ['link', 'picture', 'video']],
                            ['select', ['image', 'attachment']],
                            ['view', ['fullscreen', 'codeview', 'help']],
                        ],
                        buttons: {
                            image: imageButton,
                            attachment: attachmentButton,
                        },
                        dialogsInBody: true,
                        followingToolbar: false,
                        callbacks: {
                            onChange: function (contents) {
                                $(this).val(contents);
                                $(this).trigger('change');
                            },
                            onInit: function () {
                            },
                            onImageUpload: function (files) {
                                var that = this;
                                //依次上传图片
                                for (var i = 0; i < files.length; i++) {
                                    Upload.api.send(files[i], function (data) {
                                        var url = Fast.api.cdnurl(data.url);
                                        $(that).summernote("insertImage", url, 'filename');
                                    });
                                }
                            }
                        }
                    });
                });
            }
        } catch (e) {

        }

    };
});

});