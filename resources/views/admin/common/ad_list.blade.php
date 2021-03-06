@extends('layouts.admin')

@section('content')
    <div class="console-title">
        <a href="{{url('/admin/ad/edit')}}" class="button float-right">添加广告</a>
        <h2>广告管理</h2>
    </div>
    <div class="content-div">
        <form method="post" id="listForm" autocomplete="off">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <input type="hidden" name="eventType" value="" id="J_eventType">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listtable">
                <thead>
                <tr>
                    <th width="40" class="text-center"><label><input type="checkbox" class="checkbox checkall checkmark"></label></th>
                    <th width="60">ID</th>
                    <th>广告名称</th>
                    <th width="100">类型</th>
                    <th width="100">开始时间</th>
                    <th width="100">结束时间</th>
                    <th width="80" class="center">点击数</th>
                    <th width="80">状态</th>
                    <th width="40">编辑</th>
                </tr>
                </thead>
                <tbody id="mainbody">
                @foreach($itemlist as $id=>$item)
                <tr>
                    <td><input title="" type="checkbox" class="checkbox checkmark itemCheckBox" name="ads[]" value="{{$id}}"></td>
                    <td>{{$id}}</td>
                    <td>{{$item['title']}}</td>
                    <td>{{$item['type_name']}}</td>
                    <td>{{$item['begin_time']}}</td>
                    <td>{{$item['end_time']}}</td>
                    <td class="align-center">{{$item['click_num']}}</td>
                    <td>@if($item['available'])可用@else已停用@endif</td>
                    <td><a href="{{action('Admin\AdController@edit', ['id'=>$id])}}">编辑</a></td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <div class="float-right">{!! $pagination !!}</div>
                        <label><input type="checkbox" class="checkbox checkall checkmark"> 全选</label>
                        <label><button type="button" class="btn btn-action" data-action="delete">删除</button></label>
                        <label><button type="button" class="btn btn-action" data-action="enable">启用</button></label>
                        <label><button type="button" class="btn btn-action" data-action="disable">停用</button></label>
                        <label><button type="button" class="btn" data-action="refresh">刷新</button></label>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".btn-action").on('click', function () {
                var eventType = $(this).attr('data-action');
                if ($(".itemCheckBox:checked").length === 0){
                    DSXUI.error('请选择选项');
                    return false;
                }
                var spinner = null;
                var submitForm = function () {
                    $("#listForm").ajaxSubmit({
                        dataType:'json',
                        beforeSend:function () {
                            spinner = DSXUI.showSpinner();
                        },success:function (response) {
                            setTimeout(function () {
                                spinner.close();
                                if (response.errcode === 0){
                                    DSXUtil.reFresh();
                                }else {
                                    DSXUI.error(response.errmsg);
                                }
                            }, 500);
                        }
                    })
                }
                $("#J_eventType").val(eventType);
                if (eventType === 'delete'){
                    DSXUI.showConfirm('删除广告', '确认要删除所选广告吗?', submitForm);
                }else {
                    submitForm();
                }
            });
        });
    </script>
@stop
