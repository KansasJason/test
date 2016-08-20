<?php
/**
 * 提交Model
 */
namespace Home\Model;
use Think\Model;

class UserModel extends Model {

    protected $_map = array(
        'u_name'  => 'username',
        'pwd'      => 'password'
    );
    protected $_validate = array(
        array('username', 'require', '用户名已存在，请重新填写',0,'unique',5),
        array('password', '/^[0-9a-zA-Z]{4,10}$/', '密码格式不正确',1,'',5),
        array('repwd', 'password', '确认密码不正确',0,'confirm',5),
        array('password','/^[0-9a-zA-Z]{4,10}$/','新密码格式错误！',1,'',4),
        array('repassword','password','确认新密码不一致！',1,'confirm',4),
        array('contact','/^[0-9]{5,11}$/','联系方式格式不正确'),
    );
    /*
     * 添加
     */
    public function addUser($data) {
        return $this->add($data);
    }
}