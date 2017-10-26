<?php
function register_cocoment($board_id,$comment){
    $client = $_SESSION['user'];
}
function register_comment($bid,$comment){
    $client = $_SESSION['user'];
    $dbconnect = mysqli_connect("127.0.0.1", "root", "autoset");
    mysqli_select_db($dbconnect, "test_board");

    //댓글에 대한 댓글 아이디 값이 들어온 경우
        if(isset($_POST['comment_id'])){
           $cid=$_POST['comment_id'];
            $sql="select * from total_comment where comment_id=$cid";
            $obj=mysqli_fetch_object(mysqli_query($dbconnect,$sql));
            //받아온 comment_id가 grpno랑 안 맞으면 댓글에 대한 댓글의 id이다.
            if($obj->grpno!=$cid){
                //댓글에 대한 대댓글
                $sql="UPDATE total_comment SET grpord = grpord +1 WHERE grpno = $obj->grpno AND grpord  > $obj->grpord";
                mysqli_query($dbconnect, $sql);
                $sql = " insert into total_comment (grpno,grpord,depth,writer_id,board_id,contents)";
                $sql .= "values($obj->grpno,$obj->grpord+1,$obj->depth+1,'$client->id',$bid,'$comment')";
                mysqli_query($dbconnect, $sql);
            }
        else{
            //댓글에 대한 댓글
            //대댓글을 제외하고 댓글 grpord +1
            $sql="select count(*) from total_comment where grpno=$cid and grpord >0";
            $grpord_num=mysqli_fetch_row(mysqli_query($dbconnect, $sql));
            $sql = " insert into total_comment (grpno,grpord,depth,writer_id,board_id,contents)";
            $sql .= "values($cid, $grpord_num[0]+1,$obj->depth+1,'$client->id',$bid,'$comment')";
            mysqli_query($dbconnect, $sql);
        }
    }
    else {
        //그냥 댓글입력
        $sql = " insert into total_comment (grpord,depth,writer_id,board_id,contents)";
        $sql .= "values(0,1,'$client->id',$bid,'$comment')";
        mysqli_query($dbconnect, $sql);
        $sql = "select comment_id from total_comment order by comment_id desc limit 1";
        $c_id = mysqli_fetch_row(mysqli_query($dbconnect, $sql));
        $sql = "update total_comment set grpno = $c_id[0] where comment_id=$c_id[0] ";
        mysqli_query($dbconnect, $sql);
    }
    mysqli_close($dbconnect);
}
function desc_comment($b_id){
   $dbconnect = mysqli_connect("127.0.0.1", "root", "autoset");
    mysqli_select_db($dbconnect, "test_board");

    $sql = "select * from total_comment where board_id= $b_id  order by grpno asc, grpord asc limit 10";
    $rep=(mysqli_query($dbconnect, $sql));
    mysqli_close($dbconnect);
    return $rep;
}
