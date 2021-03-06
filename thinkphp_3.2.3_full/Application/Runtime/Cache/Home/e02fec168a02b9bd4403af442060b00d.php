<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人信息修改</title>
        <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="/Public/App/app.css">
        <script type="text/javascript" src="/Public/bootstrap/js/jquery-3.1.0.min.js"></script>
        <script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/Public/libs/js/jquery.uploadify.js"></script>
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        .modify{
            width: 800px;
            height: 600px;
            position: absolute;
            left: 260px;
        }
        .photo{
            float: left;
            position: absolute;
            top:100px;
            left: 20px;
            width: 320px;
            height: 400px;
        }
        .theme{
            height: 50px;
            border-bottom: 1px solid skyblue;
            font-size: 24px;
            line-height: 50px;
            color: dimgrey;
            padding-left: 60px;
        }

        table{
            position: absolute;
            left: 350px;
            top:80px;
            margin: 5px auto;
        }
        table tr td{
            width: 550px;
            overflow: hidden;
            height:55px;
            color: dimgrey;
            font-family: "黑体";
            font-size: 20px;
        }
        input{
            display: inline-block;
            margin: 15px 5px;
            font-size: 17px;
            line-height: 35px;
            width: 300px;

        }
        .gender{
            width: 40px;
            height: 16px;
        }
        .save{
            width: 300px;
            height: 70%;
            display: inline-block;
            margin-top: 30px;
            margin-left: 95px;
            font-size: 20px;
            color: white;
            background-color: #2c99fe;
            border-radius: 5px;
            border: none;
        }
        .saveimg{
            width: 95%;
            height: 15%;
            display: inline-block;
            position: absolute;
            margin-top: 0px;
            font-size: 20px;
            color: white;
            background-color: #2c99fe;
            font-family: "黑体";
            border-radius: 5px;
            border: none;
        }
        #changeimg img{
            height: 100px;
            width:100px;
          }
        #changeimg{
            margin-left: 100px;
        }
    </style>
</head>
<body>
<div class="modify">
    <div class="theme">
        地图标记个人信息修改
    </div>
    <div class="photo">
        <div class="see" id="changeimg"><img src=""><button id="img_upload" type="file"></button></div>
        <input id="savaimg" type="button" name="bt" value="保存头像" class="saveimg">
        <input type="text" style="display: none" id="path" name="path">
    </div>
    <form id="form_revise">


        <table>
            <tr>
                <td>
                    &nbsp;原密码: <input type = "password" id = "old_pwd" name="oldpwd">
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;新密码:&nbsp;<input type = "password" id = "new_pwd" name="password">
                </td>
            </tr>
            <tr>
                <td>
                    确认密码:<input type = "password" id = "new_repwd" name="repassword">
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;性&nbsp;别 : &nbsp;男<input type = "radio" name = "gender"  value = "male" class="gender" checked="checked">
                    女 <input type = "radio" name = "gender"  value = "female" class="gender">
                </td>
            </tr>
            <tr>
                <td>
                    联系方式:<input type="text" id = "con" name = "contact">
                </td>
            </tr>
            <tr>
                <td>
                    <input id="revise" type="button" name="bt" value="保 存" class="save">
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
    $("#revise").click(function () {
        var info = $("#form_revise").serializeArray();
        var validation = {
            'oldpwd': '请输入原密码',
            'password': '请输入新密码',
            'repassword': '请再次输入新密码',
            'contact':'联系方式不能为空',
        }
        for (var x in info) {
            if (info[x]['value'] == '') {
                alert(validation[info[x]['name']]);
                $("[name=" + info[x]['name'] + "]")[0].focus();
                return false;
            }
        }
        $.post("<?php echo U('Index/revise');?>",info).then(function (res) {
            if(res.data == 0){
                alert(res.msg);
            }
            else{
                alert(res.msg);
            }
        })
    });

    $("#img_upload").uploadify({
        formData: {},
        'swf': '/Public/libs/js/uploadify.swf',
        'uploader': "<?php echo U('Index/uploadHandler');?>",
        'fileTypeExts': '*.jpg; *.png; *.gif; *jpeg',
        'onUploadSuccess': function (file, logourl, response) {
            if (response) {
                $('.see img').attr('src', eval('(' + logourl + ')') ["data"]);
                $('#path').val(eval('(' + logourl + ')') ["data"]);
            }
        },
        'onUploadError': function (file, errorCode, errorMsg, errorString) {
            alert(file.name + '上传失败原因:' + errorString);
        },
        'buttonText': '点这里修改头像',
        'height': 30,
        'width':100,
    });
    $("#savaimg").click(function () {
        var path = $('#path').serializeArray();
        $.post("<?php echo U('Index/saveavatar');?>",path).then(function (res) {
            if(res.status == 0){
                alert(res.msg);
            }else{
                alert("修改失败了，刷新页面试试吧");
            }
        });
    })
    window.onload = function () {
        $.get("<?php echo U('Index/getimg');?>").then(function (res) {
            if(res.status == 0){
                $('#changeimg img').attr('src',res.data);
            }else{
                $('#changeimg img').attr('src','/Application/Home/View/load.jpg');
            }
        });
    }
</script>
</body>
</html>