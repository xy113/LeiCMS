@extends('layouts.mobile')

@section('title', '注册')

@section('content')
    <div class="sign">
        <form method="post" id="Form" autocomplete="off">
            {{csrf_field()}}
            <input type="hidden" name="formsubmit" value="yes">
            <div class="form-group">
                <input type="text" class="input-text" title="" name="username" id="username" placeholder="昵称，怎么称呼你">
            </div>
            <div class="form-group">
                <input type="text" class="input-text" title="" name="mobile" id="mobile" placeholder="手机号，11位号码">
            </div>
            <div class="form-group">
                <input type="password" class="input-text" title="" name="password" id="password" placeholder="登录密码，6-20位">
            </div>
            <div class="form-group">
                <button type="button" class="button" id="registerBtn">立即注册</button>
            </div>
            <div class="blank"></div>
            <div class="link">
                <a href="{{url('/mobile/login?redirect='.urlencode($redirect))}}">已有账号，立即登录</a>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        var redirect = '{{$redirect}}';
        $("#registerBtn").on('click', function () {
            var username = $.trim($("#username").val());
            if (!DSXValidate.IsUserName(username)) {
                DSXUI.error('昵称输入有误');
                return false;
            }

            var mobile = $.trim($("#mobile").val());
            if (!DSXValidate.IsMobile(mobile)) {
                DSXUI.error('手机号码输入有误');
                return false;
            }

            var password = $.trim($("#password").val());
            if (!DSXValidate.IsPassword(password)){
                DSXUI.error('密码输入有误');
                return false;
            }
            var spinner = null;
            $("#Form").ajaxSubmit({
                dataType:'json',
                beforeSend:function () {
                    spinner = DSXUI.showSpinner();
                },
                success:function (response) {
                    setTimeout(function () {
                        spinner.close();
                        if (response.errcode === 0){
                            if (redirect) {
                                window.location.href = redirect;
                            }else {
                                window.location.href = '{{url('/mobile/member')}}'
                            }
                        }else {
                            DSXUI.error(response.errmsg);
                        }
                    }, 500);
                }
            })
        });
    </script>
@stop
