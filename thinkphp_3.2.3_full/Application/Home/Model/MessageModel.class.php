<?php
/**
 * 提交Map信息 */
namespace Home\Model;
use Think\Model;
class MessageModel extends Model {
    public function addMessage($data) {
        return $this->add($data);
    }

}