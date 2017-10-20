<?php
//작성자 객체 반환
function confirm_writer($board_id){
    $dbconnect = mysqli_connect("127.0.0.1", "root", "autoset");
    mysqli_select_db($dbconnect, "test_board");
    $sql = "select * from total_board where board_id='$board_id'";
    $writer= mysqli_fetch_object(mysqli_query($dbconnect, $sql));
    mysqli_close($dbconnect);
    return $writer;
}
//게시글 DB에 기입
function input_record($id,$subject,$contents){
    $dbconnect = mysqli_connect("127.0.0.1", "root", "autoset");
    mysqli_select_db($dbconnect, "test_board");
    //게시글에 대한답글 시
    if(isset($_POST['board_id'])){
        $bid=$_POST['board_id'];
        $sql="select * from total_board where board_id=$bid";
        $obj=mysqli_fetch_object(mysqli_query($dbconnect,$sql));
        //받아온 board_id가 답글일 시
        if($obj->grpno!=$bid){
            //답글의 답글
            $sql="UPDATE total_board SET grpord = grpord +1 WHERE grpno = $obj->grpno AND grpord  > $obj->grpord";
            mysqli_query($dbconnect, $sql);
            $sql = " insert into total_board (grpno,grpord,depth,writer_id,subject,contents)";
            $sql .= "values($obj->grpno,$obj->grpord+1,$obj->depth+1,'$id','$subject','$contents')";
            mysqli_query($dbconnect, $sql);
        }
        else{
        //답글 생성
        //게시글을 제외하고 답글 grpord +1
        $sql="select count(*) from total_board where grpno=$bid and grpord >0";
        $grpord_num=mysqli_fetch_row(mysqli_query($dbconnect, $sql));
        $sql = " insert into total_board (grpno,grpord,depth,writer_id,subject,contents)";
        $sql .= "values($bid, $grpord_num[0]+1,$obj->depth+1,'$id','$subject','$contents')";
        mysqli_query($dbconnect, $sql);
        }
    }
    else {
        //그냥 게시글 입력
        $sql = " insert into total_board (grpord,depth,writer_id,subject,contents)";
        $sql .= "values(0,1,'$id','$subject','$contents')";
        mysqli_query($dbconnect, $sql);
        $sql="select board_id from total_board order by board_id desc limit 1";
        $b_id=mysqli_fetch_row(mysqli_query($dbconnect, $sql));
        $sql="update total_board set grpno = $b_id[0] where board_id='$b_id[0]' ";
        mysqli_query($dbconnect, $sql);
    }
   mysqli_close($dbconnect);
}
//게시판 내부 글 보기
function see_record($b_id){
    $dbconnect = mysqli_connect("127.0.0.1", "root", "autoset");
    mysqli_select_db($dbconnect, "test_board");
    $sql="select * from total_board where board_id=$b_id";
    $res=mysqli_fetch_object(mysqli_query($dbconnect, $sql));
    //만일 게시글에 대한 답글,제안 글에 대한 경우 & 조회수 버그
    $sql="update total_board set hits = hits+1 where board_id=$b_id ";
    mysqli_query($dbconnect, $sql);
    mysqli_close($dbconnect);
    return $res;
}
function delete_record($b_id){
    $dbconnect = mysqli_connect("127.0.0.1", "root", "autoset");
    mysqli_select_db($dbconnect, "test_board");
    //만일 게시글에 대한 답글,제안 글에 대한 경우
    $sql="delete from total_board where board_id=$b_id";
    mysqli_query($dbconnect, $sql);
    mysqli_close($dbconnect);
}
function update_record($new_sub,$new_con,$b_id){
    $dbconnect = mysqli_connect("127.0.0.1", "root", "autoset");
    mysqli_select_db($dbconnect, "test_board");
    $renew=date('Y-m-d H:i:s',time());
    $sql="update total_board set subject ='$new_sub',contents='$new_con', reg_date='$renew' where board_id='$b_id' ";
    mysqli_query($dbconnect, $sql);
    mysqli_close($dbconnect);
}
function pagenation(){
    $dbconnect = mysqli_connect("127.0.0.1", "root", "autoset");
    mysqli_select_db($dbconnect, "test_board");
    if($_SESSION['mode']==2) {
        $req=$_GET['search'];
        switch ($_GET['select_box']) {
            case'writer_id':
                $sql = "select count(*) from total_board where  writer_id like '%$req%'";
                break;
            case 'subject':
                $sql = "select count(*) from total_board where  subject like '%$req%'";
                break;
            case 'contents':
                $sql = "select count(*) from total_board where  contents like '%$req%'";
                break;
            case 'all':
                $sql = "select count(*) from total_board where writer_id like '%$req%' ";
                $sql .= " union select count(*) from total_board where subject like '%$req%'";
                $sql .= " union select count(*) from total_board where contents like '%$req%'";
                break;
            default: break;

        }
    }else {
        $sql = "select count(*) from total_board";
    }
    $count = mysqli_fetch_row(mysqli_query($dbconnect, $sql));
    mysqli_close($dbconnect);
    return ceil($count[0]/size_page);
}
//게시판 생성
function running_sql($top){
    $max=size_page;
    $dbconnect = mysqli_connect("127.0.0.1", "root", "autoset");
    mysqli_select_db($dbconnect, "test_board");
    if($_SESSION['mode']==2) {
        $req=$_GET['search'];
        switch ($_GET['select_box']) {
            case'writer_id':
                $sql = "select * from total_board where writer_id like '%$req%' order by board_id desc limit $top,$max";
                break;
            case 'subject':
                $sql = "select * from total_board where subject like '%$req%' order by board_id desc limit $top,$max";
                break;
            case 'contents':
                $sql = "select * from total_board where contents like '%$req%' order by board_id desc limit $top,$max";
                break;
            case 'all':
                $sql = "select * from total_board where writer_id like '%$req%' ";
                $sql .= " union select * from total_board    where subject like '%$req%'  ";
                $sql .= " union select * from total_board where contents like '%$req%' order by board_id desc limit $top,$max";

                break;

        }
    }
    else{
        $sql = "select * from total_board  order by grpno desc, grpord asc limit $top,$max";
    }
    $result = mysqli_query($dbconnect, $sql);
    //게시판
    mysqli_close($dbconnect);
    return $result;
}

