<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的地图</title>
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/bootstrap/js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="/Public/bootstrap/js/bootstrap.min.js"></script>
</head>
<style>
    #container {
        width: 800px;
        height: 600px;
        border: 1px solid red;
        margin:0 auto;
    }

    .content {
        position: absolute;
        right: 0;
        z-index: 5;
        opacity: 0.8;
        top: 10px;
        border-radius: 10px;
    }

    .d {
        position: absolute;
        right: 0;
        top: 10px;
        z-index: 5;
        border: 1px solid green;
        height: 100px;
        width: 120px;
    }

    #tabcontent {
        height: 100px;
        width: 200px;
        border: 2px solid green;
        border-radius: 5px;
    }

    input {
        z-index: 10;
    }
    .info{
        position: relative;
        width: 800px;
        height: 30px;
        margin:0 auto;
    }
</style>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=790fa7a6a7b0b0b69183865979638e7f"></script>
<script type="text/javascript">


</script>

<body onload="loadmap()">
<!--存放地图的div-->
<div class="info">
    <a href="<?php echo U('Index/reviseinfo');?>">点击修改个人信息</a>
</div>
<div id="container">

</div>

<script type="text/javascript">
    var length;
    var array;
    var fg = 1;
    function loadmap() {
        $.get("<?php echo U('Main/loadmap');?>").then(function (res) {
           /* console.log(res.data[0]['message_id']);*/
            length = res.data.length; array = res.data;
            console.log(res.data);
            for (var i = 0; i < length; i++) {
                var marker = new AMap.Marker({
                    position: [array[i]['lng'], array[i]['lat']],
                    map: map
                });
                var infowindow = new AMap.InfoWindow({
                    content: '',
                    offset: new AMap.Pixel(0, -30),
                    size: new AMap.Size(230, 0)
                });
                marker.content = '<form name="data_submit">'+ array[i]['message_id']+'<textarea disabled name="text" id="tabcontent">' + array[i]['content'] + '</textarea></form>' +
                        '<button class="btn-default" type="button" id="edit" onclick="edit()">添加信息</button>' +
                        '<p class="text-danger">请添加信息确认标记</p>';
                marker.title = array[i]['message_id'];
                infowindow.open(map, [array[i]['lng'], array[i]['lat']]);

                /*悬停显示消息*/
                marker.on('mouseover', function (e) {
                    document.getElementById("m_id").value = e.target.title;
                    infowindow.setContent(e.target.content);
                    infowindow.open(map, e.target.getPosition());
                });

                /*单击删除*/
                marker.on('click', function (e) {
                    console.log(e.target.title);
                    document.getElementById("m_id").value = e.target.title;
                    var result = $("#m_id").serializeArray();
                    console.log(result);
                    $.post("<?php echo U('Main/delete');?>", result).then(function (res) {
                        if (res.status == 0) {
                            infowindow.close();
                            marker.setMap();
                            alert("删除成功");
                            location.reload()
                        } else {
                            alert("出问题了，刷新刷新页面试试吧");
                        }
                    })
                })
            }
        })
    }

    /*生成地图*/
    var map = new AMap.Map('container', {
        resizeEnable: true,
        zoom: 10
    });
    /*添加比例尺*/
    AMap.plugin(['AMap.ToolBar', 'AMap.Scale'], function () {
        var toolbar = new AMap.ToolBar();
        var scale = new AMap.Scale();
        map.addControl(toolbar);
        map.addControl(scale);
    });
    /*单击标记*/
    var infoWindow = new AMap.InfoWindow();
    map.on('click', function (e) {
        var infowindow = new AMap.InfoWindow();
        var marker = new AMap.Marker({
            position: '',
            map: map
        });
        infowindow = new AMap.InfoWindow({
            content: '<div><form name="data_submit"><textarea disabled name="text" id="tabcontent"></textarea></form>' +
            '<button class="btn-default" type="button" id="edit" onclick="edit()">添加信息</button>' +
            '<p class="text-danger">请添加信息确认标记</p>' +
            '</div>',
            offset: new AMap.Pixel(0, -30),
            size: new AMap.Size(230, 0)
        });
        infowindow.open(map, e.lnglat);
        marker.setPosition(e.lnglat);
        document.getElementById("lngdata").value = e.lnglat['lng'];
        document.getElementById("latdata").value = e.lnglat['lat'];
        marker.content = infowindow.content;
        marker.on('mouseover', function (e) {
            infowindow.setContent(e.target.content);
            infowindow.open(map, e.target.getPosition());
        });

        /*误点了鼠标左键，再点一下会直接清楚坐标标记*/
        marker.on('click', function (e) {
                infowindow.close();
                marker.setMap();
        })
    });
    function edit() {
        var flag = document.getElementById("edit").textContent;
        if (flag == "添加信息") {           /*alert("能输入");*/
            document.getElementById("content").value = document.getElementById("tabcontent").value;
            document.getElementById("tabcontent").removeAttribute("disabled");
            if (document.getElementById("content").value != '') {
                document.getElementById("edit").textContent = "更新";
            }
            else {
                document.getElementById("edit").textContent = "点击修改";
            }
            fg = 0;
        }
        if (flag == "点击修改") {
            /*alert("不能输入");*/
            var con = document.getElementById("tabcontent").value;
            document.getElementById("time").value = new Date().getTime();
            if (con != '') {
                document.getElementById("content").value = document.getElementById("tabcontent").value;
                var attr = document.createAttribute("disabled");
                attr.nodeValue = "disabled";
                document.getElementById("tabcontent").setAttributeNode(attr);
                var content = document.getElementById("tabcontent").value;
                document.getElementById("edit").textContent = "添加信息";
                fg = 1;
            } else {
                alert("请填写备注消息");
            }
        }
        if (flag == "更新") {
            document.getElementById("time").value = new Date().getTime();
            document.getElementById("content").value = document.getElementById("tabcontent").value;
            var result = $("#content,#time,#m_id").serializeArray();
            $.post("<?php echo U('Main/update');?>", result).then(function (res) {
                if (res.status == 0) {
                    alert(res.msg);
                    location.reload()
                }
            });
            var attr = document.createAttribute("disabled");
            attr.nodeValue = "disabled";
            document.getElementById("tabcontent").setAttributeNode(attr);
        }
        if (fg == 1) {
            var con = $("#mapform").serializeArray();
            console.log(con);
            $.post("<?php echo U('Main/add');?>", con).then(function (res) {
                if (res.status == 0) {
                    alert("成功标记");
                    location.reload()
                } else {
                    alert("失败了,刷新下页面重新试试吧");
                }
            })
        }
    }


</script>
<!--表单收集数据-->
<form style="/*display: none;*/" id="mapform">
    <input type="text" name="content" id="content">
    <input type="text" name="pub_time" id="time">
    <input type="text" name="lng" id="lngdata">
    <input type="text" name="lat" id="latdata">
</form>
<input type="text" name="message_id" id="m_id">
</body>
</html>