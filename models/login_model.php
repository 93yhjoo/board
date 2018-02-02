<?php
class login_model extends CI_Model{
    function __construct()
    {
        parent::__construct();

    }
    function register_u($obj)
    {
        return $this->db->insert('client',$obj);

    }
    function login($uid,$upw){
        $query = $this->db->query("select * from client where id='$uid' AND  password = '$upw'");
        return $query->num_rows();
    }
    function  put_token($s_id,$uid){
        //클라이언트 접속시 로그인 유지 관련 cookie에 대한 s_id 정보 DB저장.
        //microtime
        $expire = time() + 600;
        setcookie("cookie", $s_id, $expire, "/");
        $expire = date('Y-m-d H:i:s', $expire);
        $this->db->query("update  client set sessionid='$s_id',checktime='$expire' where id='$uid'");


    }
    function logout(){
        $obj=$this->login_info();
        foreach ($obj->result() as $row)
        {
            $s_id= $row->sessionid;
            $uid= $row->id;
            $expire = time();
            setcookie("cookie", $s_id, $expire,"/");
            $expire = date('Y-m-d H:i:s', $expire);
            $this->db->query("update  client set sessionid='$s_id',checktime='$expire' where id='$uid'");
        }
    }
    function resign(){
        $obj=$this->login_info();
        foreach ($obj->result() as $row)
        {
            $s_id= $row->sessionid;
            $expire = time();
            setcookie("cookie", $s_id, $expire,"/");
            $this->db->query("delete from client where clientid={$row->clientid}");
        }

    }
    //사용자 정보
    function login_info()
    {
        $log = $_COOKIE['cookie'];
        $result=$this->db->query("select * from client where sessionid = '$log'");


        return $result;
    }
}