<?php
class board_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
    function count_select_all($table='total_board'){
        return $this->db->count_all($table);
    }
    function get_list($start=0,$end=0){
        if($end!=0)
            $limit="LIMIT ".$start.",".$end;
        else
            $limit="";
        $sql="SELECT * FROM total_board "."WHERE grpno=0 order by reg_date desc ".$limit;
        $query=$this->db->query($sql);



        return $query->result();
    }
    function get_content($board_id){
        $sql="select b.board_id, b.writer_id, b.subject, b.contents, b.reg_date, f.file_path 
              from total_board b 
              LEFT JOIN file_info f 
              ON b.board_id =f.board_no where b.board_id=$board_id";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function upload($subject,$contents,$file=''){
        $this->db->set('grpord',0);
        $this->db->set('depth',1);
        $this->db->set('writer_id',$_SESSION['uid']);
        $this->db->set('subject',$subject);
        $this->db->set('contents',$contents);
        $this->db->insert('total_board');
        if( $file!=''){
            $board_id=0;
            $sql="SELECT board_id FROM total_board WHERE grpno=0 order by reg_date desc LIMIT 1";
            $query=$this->db->query($sql);
            foreach ($query->result() as $key){
                $board_id= $key->board_id;
                break;
            }
            for($i=0;$i<count($_FILES['uploadfile']['name']);$i++){
                $name=$_FILES['uploadfile']['name'][$i];
                $tmp_name=$_FILES['uploadfile']['tmp_name'][$i];
                $this->db->set('board_no',$board_id);
                $this->db->set('writer_id',$_SESSION['uid']);
                //파일 경로 저장
                $move_to='./upload'.'/'.$name;
                move_uploaded_file($tmp_name,$move_to);
                $file_path=base_url('upload/'.$name);
                $this->db->set('file_path',$file_path);
                $this->db->insert('file_info');
                /*경로에 파일 저장 방식
                $move_to=base_url('upload').'/'.$name;
                move_uploaded_file($tmp_name,$move_to);
                $this->db->set('filepath',$move_to);
                */

            }

        }



    }
}