<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录界面</title>
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/Public/App/app.css">
    <script type="text/javascript" src="/Public/bootstrap/js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>
</head>
<style >
    *{
        padding: 0;
        margin: 0;
        font-family: "黑体";
        font-size: 18px;
    }

    .form_div{
        border: 1px #2c99fe solid;
        border-radius: 4px;
        width: 440px;
        height: 500px;
        position: absolute;
        left: 480px;
        top:50px;

    }
    header{
        width: 100%;
        height: 60px;
        font-size: 22px;
        text-align: center;
        line-height: 55px;
        color: grey;
        background-color: #E2E8FF;

    }
    .map_table{
        margin: 35px auto;
        margin-left: 30px;
    }
    .map_table tr td{
        width: 350px;
        overflow: hidden;
        height:55px;
        /*border: 1px red solid;*/
    }
    .map_table td input{
        display: inline-block;
        margin: 15px 5px;
        font-size: 16px;
        font-family: "宋体";
        line-height: 40px;
        width: 280px;
    }

    a{
        text-decoration: none;
        font-size:14px;
    }
    .avatar{
        height: 80px;
        width: 80px;
        margin:0 auto;
        display: none;
    }
    .avatar , .avatar img {
        height: 80px;
        width: 80px;
        margin:0 auto;
    }
    .btn-block{
        width: 100%;
        height: 100%;
        display: inline-block;
        font-size: 20px;
        /*font-weight: bold;*/
        color: white;
        background-color: #2c99fe;
        border-radius: 5px;
        border: none;

    }
    .btn-block:hover{
        opacity: 0.8;
    }

</style>
<body>
<div class="form_div">
    <form id="map_form">
        <header>地图标记账号登陆</header>
        <div class="avatar"><img id="imgava" src=""></div>
        <table class="map_table">
            <tr>
                <td class="panel-title">用户名</td>
                <td><input type="text" placeholder="请输入用户名" name="u_name" id="map_name"></td>
                <td class="text-danger">*</td>
            </tr>
            <tr>
                <td class="title">密&nbsp; 码</td>
                <td><input type="password" placeholder="请输入您的密码" name="pwd"></td>
                <td class="text-danger">*</td>
            </tr>
            <tr>
                <td colspan="3" style="height: 30px">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="login"><button id="map_login" class="btn-block" type="button">登 录</button></td>
                <td class="text-danger"></td>
            </tr>

            <tr>
                <td></td>
                <td style="text-align: right">
                    <a href="<?php echo U('Index/register');?>" >马上注册</a>
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
    $("#map_login").click(function () {
        var login = $('#map_form').serializeArray();
        var validation = {
            'u_name' :'请输入您的用户名',
            'pwd' : '请输入密码',

        }
        for (var x in login) {
            if (login[x]['value'] == '') {
                alert(validation[login[x]['name']]);
                $("[name=" + login[x]['name'] + "]")[0].focus();
                return false;
            }
        }
        $.post("<?php echo U('Index/check');?>" , login).then(function (resp) {
            if(resp.status == 0){
                $id = resp.data;
                window.location.href="<?php echo U('Main/main');?>";
            }else{
                alert(resp.msg);
            }
        });
    });
    $("#map_name").blur(function () {
        var name = $('#map_name').serializeArray();
        $.post("<?php echo U('Index/search');?>",name).then (function (res){
            if(res.status == 0){
                $('.avatar img').attr('src',res.data);
                $('.avatar').show();
            }else{
                $('#imgava').css("display","none");
            }
        })
    });

</script>
</body>

</html>