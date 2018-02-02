<?php
class login_controller extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->helper('url');
    }
    function register_user(){

        $user_info=array(
            'id'=>$_POST['register_id'],
            'password'=>$_POST['register_password'],
            'level'=>'customer',
        );

        $result =$this->login_model->register_u($user_info);
        if($result==true){
            //자동 로그인 작동

        }
    }
    function login_u(){
        $result =$this->login_model->login($_POST['id'],$_POST['password']);
        if($result>0){
            session_destroy();
            session_start();
            session_regenerate_id();
            $s_id = session_id();
            $this->login_model->put_token($s_id,$_POST['id']);
            $_SESSION['uid']=$_POST['id'];
            redirect(base_url('index.php'));
        }
    }
    function logout(){
        $this->login_model->logout();
        redirect(base_url('index.php'));
    }
    function resign(){
        $this->login_model->resign();
        echo"<script>alert('탈퇴되었습니다.');</script>";
        redirect(base_url('index.php'));
    }
    function info(){

    }

}
?>