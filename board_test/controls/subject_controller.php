<?php
include $_SERVER['DOCUMENT_ROOT']."\board_test\models\model.php";
class subject_control
{       private $model;
    function __construct()
    {
        $this->model=new login_model();
    }
//올바른 접근 확인(알맞은 사용자)
    function permission($obj)
    {

        $user_obj =  $this->model->login_info();
        try {
            if ($obj->writer_id == $user_obj->id) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    function situation($mode)
    {
        switch ($mode) {
            case 'write':
                $this->write_form();
                break;
            case 'answer':
                $this->access_answer();
                break;
            case 'submit':
                $this->write_on();
                break;
            case 'access_update':
                $this->access_update();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
            default:
                break;
        }
    }

//글 작성 형식
    function write_form()
    {
        echo "
<form action='../views/view_subject.php' method='post'>
<p>제목<input type='text' name='subject'></p>
<p>내용</p>
<textarea style='width:220px; height:340px; resize: none' name='contents'>
</textarea>
    <div>
    <input type='hidden' name='mode' value='submit'>
    <input type='submit' value='제출'>
    </div>
</form>";
    }
//답글 달기
function access_answer(){
    $obj = see_record($_POST["board_id"]);
    echo "
<form action='../views/view_subject.php' method='post'>
<p>제목<input type='text' name='subject' value='$obj->subject'></p>
<p>내용</p>
<textarea style='width:220px; height:340px; resize: none' name='contents'>
</textarea>
    <div>
    <input type='hidden' name='board_id' value='$obj->board_id'>
    <input type='hidden' name='mode' value='submit'>
    <input type='submit' value='제출'>
    </div>
</form>";
}
//글 내용  수정 창
    function access_update()
    {
        $obj = see_record($_POST["board_id"]);
        echo "
<form action='../views/view_subject.php' method='post'>
<p>제목<input type='text' name='subject' value='$obj->subject'></p>
<p>내용</p>
<textarea style='width:220px; height:340px; resize: none' name='contents' >$obj->contents
</textarea>
    <div>
    <input type='hidden' name='mode' value='update'>
     <input type='hidden' name='board_id' value='$obj->board_id'>
    <input type='submit' value='제출'>
    </div>
</form>";
    }

//글 작성
    function write_on()
    {
        if ($_POST["subject"] != "" && $_POST["contents"] != "") {
            $subject = $_POST["subject"];
            $contents = $_POST["contents"];
        } //없다면
        elseif ($_POST["subject"] == "") {
            $contents = $_POST["contents"];
            $subject = "[제목없음]";
        } elseif ($_POST["contents"] == "") {
            $subject = $_POST["subject"];
            $contents = "내용없음";
        } else {
            $subject = "[제목없음]";
            $contents = "내용없음";
        }
        $obj = $this->model->login_info();
        input_record($obj->id, $subject, $contents);
        echo "<script>window.location.replace('http://127.0.0.1:8080/board_test/views/board_view.php')</script>";
    }

//글 수정
    function update()
    {
        if ($_POST["subject"] != "" && $_POST["contents"] != "") {
            $subject = $_POST["subject"];
            $contents = $_POST["contents"];
        } //없다면
        elseif ($_POST["subject"] == "") {
            $contents = $_POST["contents"];
            $subject = "[제목없음]";
        } elseif ($_POST["contents"] == "") {
            $subject = $_POST["subject"];
            $contents = "내용없음";
        } else {
            $subject = "[제목없음]";
            $contents = "내용없음";
        }
        update_record($subject, $contents, $_POST['board_id']);
        echo "<script>history.go(-2);</script>";
    }

//글 내용보기
    function show_record($req)
    {
        $result_obj = see_record($req);
        echo "<table class='table table-bordered'>
        <tr><th colspan='0'><p style='text-align: center'>$result_obj->subject</p></th></tr>
        <tr><td><h6>작성자</h6>$result_obj->writer_id</td></tr>
        <tr><td style=''>$result_obj->contents</td></tr>
        </table>";
        if (isset($_COOKIE['cookie'])) {
            if ($this->permission($result_obj) === true) {
                echo "<div>";
                echo "<form action='../views/view_subject.php' method='post'>
      <input type='hidden' name='board_id' value='$req'>
       <input type='hidden' name='mode' value='access_update'>
<input type='submit' value='수정'></form>";

                echo "<form action='../views/view_subject.php' method='post'>
    <input type='hidden' name='board_id' value='$req'>
     <input type='hidden' name='mode' value='delete'>
    <input type='submit' value='삭제'></form>";
                echo "</div>";
            }

                echo "<form action='../views/view_subject.php' method='post'>
    <input type='hidden' name='board_id' value='$req'>
     <input type='hidden' name='mode' value='answer'>
    <input type='submit' value='답글 달기'></form>";
                echo "</div>";

        }
    }

//글 삭제.
    function delete()
    {
        $b_id = $_POST['board_id'];
        delete_record($b_id);
        echo "<script>window.location.replace('http://127.0.0.1:8080/board_test/views/board_view.php')</script>";
    }

}
