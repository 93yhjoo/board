<?php
include $_SERVER['DOCUMENT_ROOT']."\board_test\models\comment_model.php";
const comment_page=10;
class comment_control{


function confirm($argbid){
if (isset($_COOKIE['cookie'])) {
    $address = "view_subject.php?board_id=$argbid";
//로그인 시 댓글 등록창 띄우기
$this->comment_register($address);
}



}

function input_comment($argbid,$argcontent){
    register_comment($argbid,$argcontent);
}
//댓글 등록창.
function comment_register($address){
    echo "<div class='form-horizontal'>";
    echo "<form class='form-group' action='$address' method='post'>";
    echo "<textarea name='comment' class='form-control' rows='3' style='resize:none' ></textarea>";
    echo "<input class='btn btn-default' type='submit' value='등록'>";
    echo "</form>";
    echo "</div>";
}
//댓글창
function comment_table($b_id) {
    echo "<div><h3>코멘트 창</h3>";
    $rep = desc_comment($b_id);

    for ($i = 0; $i < comment_page; $i++) {

        $row = mysqli_fetch_object($rep);
        if (is_object($row)) {
            echo"<div>";
            echo "<dl class='dl-horizontal'>";
            if($row->grpord!=0){
                $string="";
                for($i=1;$i<$row->depth;$i++){
                    $string.="&raquo;";
                }
                echo "<dt><p class='text-left'>$string RE $row->writer_id</p></dt><dd>&nbsp;$row->reg_date&nbsp;<a href='#' id=$row->comment_id onclick=create_dash($b_id,$row->comment_id)>댓글</a></dd>";
            }else{
                echo "<dt><p class='text-left'> $row->writer_id</p></dt><dd>&nbsp;$row->reg_date&nbsp;<a href='#' id=$row->comment_id onclick=create_dash($b_id,$row->comment_id)>댓글</a></dd>";
            }
            echo "<dd>$row->contents</dd>";
            echo "</dl>";
            echo"</div>";
            echo "<div name='$row->comment_id'></div>";
        }
    }
    echo "</div>";
}
}