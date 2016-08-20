<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class MainController extends Controller {
    public function index(){
        $this->display();
    }
    public function add(){
        $Message = D('Message');
        $data = $Message->create(I('post.'));
        $value = session('id');
        $data['user_id'] = $value;
        $flg = $Message->addMessage($data);
             if ($flg) {
                 $this->ajaxReturn(array(
                     'data' => $flg,
                     'status' => 0,
                     'msg' => '备注成功'
                 ));
             } else {
                 $this->ajaxReturn(array(
                     'data' => '',
                     'status' => -1,
                     'msg' => '备注失败'
                 ));
             }
         }

    public function delete(){
        $Message = D('Message');
        $id = $_POST['message_id'];
        if($Message->where("message_id = '$id'")->delete()){
            $this->ajaxReturn(array(
                'data' => '',
                'status'  => 0,
                'msg' => '成功删除'
            ));
        }else{
            $this->ajaxReturn(array(
                'data' => '',
                'status'  => -1,
                'msg' => 'abc'
            ));
        }
    }
    public function loadmap(){
        $Model = new Model();
        $id = session('id');
        $data = $Model->query("select lng,lat,content,message_id from m_message where user_id = '$id'");
        $this->ajaxReturn(array(
            'data' => $data,
            'status' => 0,
            'msg'    =>'加载成功'
        ));
    }

    public function update(){
        $Message = D("Message");
        $content = $_POST['content'];$time = $_POST['pub_time'];
        $m_id = $_POST['message_id'];
        $Message->content = $content;
        $Message->pub_time = $time;
        $flg = $Message->where("message_id = '$m_id'")->save();
        if($flg) {
            $this->ajaxReturn(array(
                'data' => $content,
                'status' => 0,
                'msg' => '更新成功'
            ));
        }
    }


}