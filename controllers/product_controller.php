<?php
class product_controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('product_model');
        $this->load->helper('url');
    }
    public function  _remap($method, $params = array()){
        //로그인 창
        $this->load->view('login_view');
        //method에 대한 parameter가 올 시 ..
        if(method_exists($this,$method)){
            call_user_func_array(array($this, $method), $params);
        }
    }
    function buy(){
        $data['list']=$this->product_model->insert_history($_POST['board_id']);
        $this->load->view('user_view',$data);

    }
    function show_history(){
        $data['list']=$this->product_model->show_history();
        $this->load->view('user_view',$data);
    }
}