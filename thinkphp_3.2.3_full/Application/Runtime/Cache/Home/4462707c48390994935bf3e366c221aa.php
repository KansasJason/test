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
    #container{
        width:800px;
        height:600px;
        border:1px solid red;
        margin:0 auto;
    }
    .content{
        position: absolute;
        right: 0;
        z-index: 5;
        opacity: 0.8;
        top: 10px;
        border-radius: 10px;
    }
    .d{
        position: absolute;
        right: 0;
        top:10px;
        z-index: 5;
        border:1px solid green;
        height: 100px;
        width: 120px;
    }
    #tabcontent{
        height:100px;
        width:200px;
        border:2px solid green;
        border-radius: 5px;
    }
    input{
        z-index:10;
    }
</style>
<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=790fa7a6a7b0b0b69183865979638e7f"></script>
<script type="text/javascript">
    var fg = 1;
    function edit(){
        var flag = document.getElementById("edit").textContent ;
        if(flag == "添加信息"){
            document.getElementById("tabcontent").removeAttribute("disabled");
            document.getElementById("edit").textContent = "点击修改";
            /*alert("能输入");*/
            fg = 0;
        }
        if(flag == "点击修改"){
            /*alert("不能输入");*/
            document.getElementById("time").value = new Date().getTime();
            document.getElementById("content").value =document.getElementById("tabcontent").value ;
            var attr = document.createAttribute("disabled");
            attr.nodeValue = "disabled";
            document.getElementById("tabcontent").setAttributeNode(attr);
            var content = document.getElementById("tabcontent").value;
            document.getElementById("edit").textContent = "添加信息";
            fg = 1;
        }
        if(fg==1){
            var con = $("#mapform").serializeArray();
            console.log(con);
            $.post("<?php echo U('Index/add');?>" , con).then(function (respon) {
                if(respon.status == 0){
                    alert("cheggong");
                }else{
                    alert("shiabi");
                }
            })
        }
    }
</script>

<body>
<div id="container">
</div>

<script type="text/javascript">
    /*生成地图*/
    var map = new AMap.Map('container',{
        resizeEnable: true,
        zoom: 10
    });
    /*添加比例尺*/
    AMap.plugin(['AMap.ToolBar','AMap.Scale'],function(){
        var toolbar = new AMap.ToolBar();
        var scale = new AMap.Scale();
        map.addControl(toolbar);
        map.addControl(scale);
    });
    /*单击标记*/
    var infoWindow = new AMap.InfoWindow();
    map.on('click',function(e){
        var infowindow = new AMap.InfoWindow();
        /*var data = document.getElementById("content").value;*/
        var marker = new AMap.Marker({
            position: '',
            map:map
        });
        infowindow = new AMap.InfoWindow({
            content: '<div><form name="data_submit"><textarea disabled name="text" id="tabcontent"></textarea></form><button class="btn-default" type="button" id="edit" onclick="edit()">添加信息</button></div>',
            offset: new AMap.Pixel(0, -30),
            size:new AMap.Size(230,0)
        });
        infowindow.open(map,e.lnglat);
        marker.setPosition(e.lnglat);
        console.log(e.lnglat['lat']);
        console.log(e.lnglat['lng']);
        document.getElementById("lngdata").value = e.lnglat['lng'];
        document.getElementById("latdata").value = e.lnglat['lat'];
        marker.content =infowindow.content;
        marker.on('mouseover',function (e){
            infowindow.setContent(e.target.content);
            infowindow.open(map, e.target.getPosition());
        });
        marker.on('click',function (e) {
            marker.setMap();
            infowindow.close(e);
        })
    });
</script>
<form style="display: none;" id="mapform">
    <input type="text" name="content" id="content" >
    <input type="text" name="pub_time" id="time" >
    <input type="text"  name="lng" id="lngdata" >
    <input type="text"  name="lat" id="latdata">
</form>
</body>
</html>