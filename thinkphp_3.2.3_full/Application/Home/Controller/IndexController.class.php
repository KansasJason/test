<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index(){
        $this->display();
    }
    public function verify ($verifyCode = '') {
        $Verify = new \Think\Verify();                           //生成验证码
        if ($verifyCode !== '') {
            return $Verify->check($verifyCode, 'feedback');     //$verifyCode 是用户输入的，与feedback标识处的比对，判断输入是否输入正确
        }
        $Verify->fontSize = 30;
        $Verify->length   = 3;
        $Verify->useNoise = false;
        $Verify->entry('feedback');                             //  验证码输出到界面上 里边的参数是可标识的信息（理解为id就行）
    }
    public function check(){
        $User = M('User');
        $name = $_POST['u_name'];
        $pwd = $_POST['pwd'];
        $id = $User->where("username = '$name'")->getField('user_id');
        session('id',$id);
        $password =$User->where("username = '$name'")->getField('password');

        if($id > 0 && $password === $pwd){
            $this->ajaxReturn(array(
                'data'   =>  '',
                'status' => 0,
                'msg'    => '登录成功'
            ));
        }else if($id >0 && $pwd !== $password){
            $this->ajaxReturn(array(
                'data' =>  '',
                'status' => -1,
                'msg'    => '密码错误'
            ));
        }
        else{
            $this->ajaxReturn(array(
                'data' =>  '',
                'status' => -1,
                'msg'    => '用户名不存在'
            ));
        }
    }
   public function add(){
        $User = D("User");
       $a = $User->avatar = '';
       if (!$this->verify(I('post.verify'))) {
           return $this->ajaxReturn(array(
               'data'   =>$a,
               'status' => -1,
               'msg'    => '验证码输入错误'
           ));
       }
        $data = $User->create(I('post.'),5);
        if(false === $data){
            $this->ajaxReturn(array(
                'data'    => '',
                'status' => -1,
                'msg'    => $User->getError()
            ));
        }
        $flg = $User->addUser($data);
        if ($flg) {
            $this->ajaxReturn(array(
                'data'   => $data,
                'status' => 0,
                'msg'  => '注册成功'
            ));
        } else {
            $this->ajaxReturn(array(
                'data'   => '',
                'status' => -1,
                'msg'    => '注册失败'
            ));
        }
    }
    public function uploadHandler () {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->savePath  =      '/Uploads/'; // 设置附件上传目录
        // 上传文件
        $info   =   $upload->upload();
        if ($info) {
            $this->ajaxReturn(array(
                'data'   =>  '/Uploads/' . $info['Filedata']['savepath'] . $info['Filedata']['savename'],
                'status' => 0,
                'msg'    => 'ok great '
            ));
        } else {
            $this->ajaxReturn(array(
                'data'   => '',
                'status' => -1,
                'msg'    => $upload->getError()
            ));
        }
    }
    public function search(){
        $User = D("User");
        $name = $_POST['u_name'];
        $url = $User->where("username = '$name'")->getField("avatar");
        if($url){
            $this->ajaxReturn(array(
                'data' => $url,
                'status' => 0,
                'msg'   => "头像获取成功"
            ));
        }else{
            $this->ajaxReturn(array(
                'data' => $url,
                'status' => -1,
                'msg'   => "头像获取失败"
            ));
        }
    }
    public function revise(){
        $User = D("User");
        if (!$this->checkpwd(I('post.oldpwd'))) {
            return $this->ajaxReturn(array(
                'data'   =>'',
                'status' => -1,
                'msg'    => '原密码输入错误'
            ));
        }else{
            $id = session('id');
            $data = $User->create(I('post.'),4);
            if(false === $data){
                $this->ajaxReturn(array(
                    'data'    => '',
                    'status' => -1,
                    'msg'    => $User->getError()
                ));
            }
            $flg = $User->where("user_id = '$id'")->save($data);
            if($flg){
                return $this->ajaxReturn(array(
                    'data'   =>'',
                    'status' => 0,
                    'msg'    => '修改成功'
                ));
            }
            else{
                return $this->ajaxReturn(array(
                    'data'   =>$flg,
                    'status' => -1,
                    'msg'    => '修改失败'
                ));
            }
        }
    }
    public function checkpwd($data){
        $User = M("User");
        $id = session("id");
        $pwd = $User->where("user_id = '$id'")->getField('password');
        if($data != $pwd){
            return false;
        }else{
            return true;
        }
    }
    public function getimg(){
        $User = D("User");
        $id = session("id");
        $url = $User->where("user_id = '$id'")->getField("avatar");
        if($url){
            $this->ajaxReturn(array(
                'data' => $url,
                'status' => 0,
                'msg'   => "头像获取成功"
            ));
        }
    }
    public function saveavatar(){
        $User = D("User");
        $id = session("id");
        $User->avatar = $_POST['path'];
        $flg = $User->where("user_id = '$id'")->save();
        if($flg){
            $this->ajaxReturn(array(
                'data' => '',
                'status' => 0,
                'msg'   => "头像修改成功"
            ));
        }else{
            $this->ajaxReturn(array(
                'data' => '',
                'status' => -1,
                'msg'   => "头像修改失败"
            ));
        }
    }

}



