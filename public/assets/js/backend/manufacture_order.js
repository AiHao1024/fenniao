define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'manufacture_order/index' + location.search,
                    add_url: 'manufacture_order/add',
                    edit_url: 'manufacture_order/edit',
                    del_url: 'manufacture_order/del',
                    multi_url: 'manufacture_order/multi',
                    table: 'manufacture_order',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'user.username', title: __('User.username')},
                        // {field: 'user_id', title: __('User_id')},
                        {field: 'ordersn', title: __('Ordersn')},
                        {field: 'company_name', title: __('Company_name')},
                        {field: 'name', title: __('Name')},
                        {field: 'phone', title: __('Phone')},
                        // {field: 'form_image', title: __('Form_image'), events: Table.api.events.image, formatter: Table.api.formatter.image,operate:false},
                        {field: 'drawing_image', title: __('Drawing_image'), events: Table.api.events.image, formatter: Table.api.formatter.image,operate:false},
                        {field: 'pay_image', title: __('Pay_image'), events: Table.api.events.image, formatter: Table.api.formatter.image,operate:false},
                        {field: 'create_time', title: __('Create_time'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'construction_image', title: __('Construction_image'), events: Table.api.events.image, formatter: Table.api.formatter.image,operate:false},
                        {field: 'invoice_image', title: __('Invoice_image'), events: Table.api.events.image, formatter: Table.api.formatter.image,operate:false},
                        {field: 'status', title: __('Status'), searchList: {"examin":__('Examin'),"reply":__('Reply'),"confirm":__('Confirm'),"unpaid":__('Unpaid'),"conduct":__('Conduct'),"finish":__('Finish')}, formatter: Table.api.formatter.status},
                        {field: 'fenlei.name', title: __('Classification'), searchList: function (column) {
                                return Template('fenleitpl', {});
                            }},
                        // {field: 'process', title: __('Process'), searchList: {"examin":__('Examin'),"confirm":__('Confirm'),"conduct":__('Conduct'),"finish":__('Finish')}, formatter: Table.api.formatter.normal},
                        // {field: 'is_invoice', title: __('Is_invoice')},

                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });
            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            },

        }
    };
    return Controller;
});