<?php
class product_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();

    }
    function insert_history($board_no){
        $this->db->set('board_no',$board_no);
        $this->db->set('buyer_id',$_SESSION['uid']);
        $this->db->insert('sales_history');


        return $this->show_history();
    }
    function show_history(){
        $sql="select h.buyer_id, f.writer_id, f.price, f.file_path, h.buy_date
              from sales_history h 
              LEFT JOIN file_info f 
              ON h.board_no =f.board_no where h.buyer_id='{$_SESSION['uid']}'";
        $query=$this->db->query($sql);
        return $query->result();
    }
}