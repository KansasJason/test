<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册界面</title>
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/bootstrap/js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Public/libs/js/jquery.uploadify.js"></script>
</head>
<style>

    .reg{
        height: 50px;
        border-bottom: 1px solid skyblue;
        font-size: 24px;
        line-height: 50px;
        color: dimgrey;
        text-align: left;
        padding-left: 30px;
    }
    .return_login{
        float: left;
        position: absolute;
        top: 20px;
        right: 10px;
        color: gray;
    }
    #reg {
        position: relative;
        width: 740px;
        height: 60%;
        /*border: 5px solid #2aabd2;*/
        border-radius: 15px;
        text-align: center;
        margin: 10px auto;
    }

    .reg_table {
        text-align: center;
        display: inline-block;
        margin-top: 20px;
        /*border: 1px red solid;*/
        width: 560px;
    }
    .reg_table tr td{
        /*border: 1px red solid;*/
        width: 470px;
        overflow: hidden;
        height:50px;
        text-align: right;
        color: dimgrey;
        font-family: "黑体";
        font-size: 20px;
    }

    .reg_table td input {
        height: 40px;
        width: 400px;
        font-size: 16px;
        margin: 10px auto;
    }

    .reg_table .see {
        position: relative;
        top: 8px;
        left: 20px;
        display: none;
    }

    .see, .see img {
        display: block;
        float: left;
        width: 36px;
        height: 36px;
    }
    .verify_img{
        width: 130px;
        height: 50px;
        margin-right: 10px;
    }
    #reg_submit{
        line-height: 40px;
        width: 200px;
        font-size: 18px;
        margin-top: 20px;
        margin-right: 200px;
    }
    .swfupload{
        border:1px solid red;
        position: relative;
        margin-left: -160px;
        border-radius: 10px;
        background-color: #2aabd2;
        opacity: 0.2;
    }
</style>
<body>
<form id="reg">
    <div class="reg">地图标记账号注册</div>
    <div class="return_login">我已注册，现在就<a href="<?php echo U('Index/index');?>"><span style="font-size: 16px">登录</span></a></div>
    <table class="reg_table">
        <tr>
            <td class="title">用户名：</td>
            <td><input type="text" placeholder="请输入用户名" name="u_name">*</td>
            <!--<td><p class="text-right">输入不能为空</p></td>-->
            <!--<td class="text-danger">*</td>-->
        </tr>
        <tr>
            <td class="title">性&nbsp;别：</td>
            <td style="text-align: left" class="gender">&nbsp;&nbsp;
                <input type="radio" name="gender" value="male" checked="checked" style="height: 18px; width: 20px">男&nbsp;&nbsp;
                &nbsp;<input type="radio" name="gender" value="female" style="height: 20px;width: 18px">女</td>
            <!--<td><p class="text-right">请选择性别</p></td>-->
            <!--<td class="text-danger">*</td>-->
        </tr>
        <tr>
            <td class="title">联系方式：</td>
            <td><input type="text" placeholder="请填写手机或者QQ" name="contact">*</td>
            <!--<td><p class="text-right">请填写手机或者QQ</p></td>-->
            <!--<td class="text-danger">*</td>-->
        </tr>

        <tr>
            <td class="title">密&nbsp;码：</td>
            <td><input type="password" placeholder="请输入4-10位的字母或数字" name="pwd">*</td>
            <!--<td><p class="text-right">请输入4-10位的字母或数字</p></td>-->
            <!--<td class="text-danger">*</td>-->
        </tr>
        <tr>
            <td class="title">确认密码：</td>
            <td><input type="password" placeholder="请再次输入您的密码" name="repwd">*</td>
            <!--<td><p class="text-right">两次密码须一致</p></td>-->
            <!--<td class="text-danger">*</td>-->
        </tr>
        <tr>
            <td class="title">验证码：</td>
            <td align="left"><input type="text" placeholder="请输入右侧验证码" name="verify" style="width: 250px">*
                <img src="<?php echo U('Index/verify');?>" id="verify_code"  class="verify_img"></td>
            <!--<td></td>-->
            <!--<td class="text-danger">*</td>-->
        </tr>
        <tr>
            <td class="title">头&nbsp;像：</td>
            <td>
                <input type="file" id="img_upload" class="upload">
                <a href="" target="_blank" class="see" ><img src="" ></a>
                <span style="font-size: 15px;padding-right: 145px">支持 *.jpg *.jpeg *.png *.gif类型</span>
            </td>
            <!--<td><p class="upload-desc">支持 *.jpg *.jpeg *.png *.gif类型</p></td>-->
        </tr>

        <tr>
            <td></td>
            <td>
                <button id="reg_submit" class="btn btn-default" type="button">确认注册</button>
            </td>
        </tr>
        <tr>
            <td colspan="3"><input name="avatar" id="imgpath" style="display: none" type="text" ></td>
        </tr>
    </table>
</form>
<script>
    $("#reg_submit").click(function () {
        var registerInfo = $("#reg").serializeArray();
        console.log(registerInfo);
        var validation = {
            'u_name': '用户名必填',
            'pwd': '请输入密码',
            'repwd': '请再次输入密码',
            'verify': '需要填写验证码',
            'contact':'需要填写联系方式',
            'avatar': '上传一张图片作为头像吧'
        }
        for (var x in registerInfo) {
            if (registerInfo[x]['value'] == '') {
                alert(validation[registerInfo[x]['name']]);
                $("[name=" + registerInfo[x]['name'] + "]")[0].focus();
                return false;
            }
        }
        $.post("<?php echo U('Index/add');?>", registerInfo).then(function (res) {
            if (res.status == 0) {
                alert(res.msg);
                /* window.location.href = "<?php echo U('Index/index');?>";*/
            } else {
                alert(res.msg);
            }
        })
    });
    $('body').on('click', '#verify_code', function () {
        $(this).attr('src', '<?php echo U("Index/verify");?>');//attr方法改变属性的值
    });
    $("#img_upload").uploadify({
        formData: { },
        'swf': '/Public/libs/js/uploadify.swf',
        'uploader': "<?php echo U('Index/uploadHandler');?>",
        'fileTypeExts': '*.jpg; *.png; *.gif; *jpeg',
        'onUploadSuccess': function (file, logourl, response) {
            if (response) {
                console.log(eval('(' + logourl + ')') ["data"]);
                $('.see').attr('href', logourl);
                $('.see img').attr('src', eval('(' + logourl + ')') ["data"]);
                $('.see').show();
                $("#imgpath").val(eval('(' + logourl + ')') ["data"]);
            }
        },
        'onUploadError': function (file, errorCode, errorMsg, errorString) {
            alert(file.name + '上传失败原因:' + errorString);
        },
        'buttonText': '点击这里选择头像',
        'height': 30,
        'width': 160,
    });
</script>
</body>
</html>