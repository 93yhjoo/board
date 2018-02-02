<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main_controller extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('board_model');
        $this->load->helper('form');
        //폼 검증 필드 로드
        $this->load->library('form_validation');
        //url 헬퍼 로드
        $this->load->helper('url');
        //페이지네이션 로드

        $this->load->library('pagination');
        //URI 로드-->3.X이상부터는 클래스로 지원하기에 필요없음.
        //$this->load->library('uri');

    }

    public function index()
    {
        $this->lists();
    }

    public function  _remap($method, $params = array()){
        //로그인 창
        $this->load->view('login_view');
        //method에 대한 parameter가 올 시 ..
        if(method_exists($this,$method)){
            call_user_func_array(array($this, $method), $params);
        }
    }
    public function lists(){

        //페이지 네이션
        $config['base_url']=base_url('index.php/main_controller/index/');
        $config['total_rows']=$this->board_model->count_select_all();
        $config['per_page']=5;
        $config['uri_segment']=3;
        //페이지네이션 커스터 마이즈
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open']='<li>';
        $config['num_tag_close']='</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#"> ';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        //페이지네이션 생성

        $this->pagination->initialize($config);

        $data['pagination']= $this->pagination->create_links();

        $page=$this->uri->segment($config['uri_segment'],0);

        $data['list']=$this->board_model->get_list($page,$config['per_page']);


        $this->load->view('board_view',$data);
    }
    function view($get){
        $data['list']=$this->board_model->get_content($get);
        $this->load->view('contents_view',$data);
    }
    function write(){
        if(isset($_COOKIE['cookie'])) {
            $config['upload_path'] = base_url('upload');
            $config['allowed_types'] = 'mxl|musicxml';
            $config['max_size'] =ini_get('post_max_size');
            $multiple=1;
            $unit=substr($config['max_size'],-1);
            switch ($unit){
                case 'M':
                    $multiple=1024*1024;
                    break;
                case 'K':
                    $multiple=1024;
                    break;
                case 'G':
                    $multiple=1024*1024*1024;
            }
            $config['max_size']=substr($config['max_size'],0,strlen($config['max_size'])-1)*$multiple;
            //높이,너비에 제한 없음.
            $config['max_width'] = '0';
            $config['max_height'] = '0';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());

                $this->load->view('write_view', $error);
            }
            else {
                $data = array('upload_data' => $this->upload->data());

                //$this->load->view('write_view', $data);
            }
        }else{
            redirect(base_url('index.php'));
        }
    }
    function submit(){

        $rule=array(
            'subject' => $_POST['subject'],
            'contents'=>$_POST['contents'],
        );
        $this->form_validation->set_rules('subject', '제목', 'required',
            array('required'=>'제목가 필요합니다.')
        );
        if($this->form_validation->run()==false){
            echo "<script>alert(' 필수 요건이 없습니다.');</script>";
            $this->write();
        }else {
            if($_FILES['uploadfile']['size'][0]==0){
                $this->board_model->upload($_POST['subject'], $_POST['contents']);
            }
            else {
                $this->board_model->upload( $_POST['subject'],$_POST['contents'],$_FILES['uploadfile']);
                redirect(base_url('index.php'));
            }

        }
        redirect(base_url('index.php'));
    }
}
?>