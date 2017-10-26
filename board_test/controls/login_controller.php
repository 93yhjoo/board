
<?php
class customer{
    public $id;
    public $password;
    public $level;
    function __construct()
    {
        $this->level="customer";
    }
}
include  $_SERVER['DOCUMENT_ROOT']."\board_test\models\login_model.php";
//로그 아웃 쿠키 만료기한 설정.
class login_control{
    private $model;
    function __construct()
{
    $this->model=new login_model();
}

    function check_mode(){
    if (isset($_POST["user_mode"]))
    {
        switch ($_POST["user_mode"]){
            case "user_logout": $this->logout();
                                 break;
            case "user_login":$this->check($_POST['id'],$_POST['password']);break;
            case "user_registry":
                $obj=new customer();
                $obj->id=$_POST['register_id'];
                $obj->password=$_POST['register_password'];
                $this->register_data($obj);
                break;
            case "user_info":break;
            case "user_delete": $this->delete_data();
                                    $this->logout();
                                break;
            default: break;
        }
    }
    else{
        if (isset($_COOKIE['cookie'])) {
            $this->get_login();
        } else {
            $this->login_window();
        }
    }
    }
    //계정 로그 아웃.
    function logout(){
        $expire = time()-1000;
        setcookie("cookie", "", $expire);
        echo "<script>location.replace('board_view.php')</script>";
    }
    //계정 가입
    function register_data($obj){
        $this->model->register($obj);
        echo" <script>alert('성공적으로 가입되었습니다 계정로그인 해주세요')</script>";
        echo "<script>location.replace('board_view.php')</script>";
    }
    //계정 탈퇴
    function delete_data(){
        $this->model->delete_user();
        echo" <script>alert('성공적으로 탈퇴 완료 했습니다')</script>";
    }
function login_window(){
    echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#LoginModal'>로그인</button>";
    echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#RegisterModal'>회원가입</button>";

    //로그인 창
    echo"<div class='modal fade' id='LoginModal' tabindex='-1' role='dialog' aria-labelledby='LoginModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title' id='LoginModalLabel'>로그인창</h4>
      </div>
      <div class='modal-body''>
        <form action='board_view.php' method='post'>
        <input type='hidden' name='user_mode' value='user_login'>
          <div class='form-group'>
            <label for='id' class='control-label'>아이디</label>
            <input type='text' class='form-control' name='id'>
          </div>
          <div class='form-group'>
            <label for='password' class='control-label'>비밀번호</label>
            <input type='password' class='form-control' name='password'>
            <button type='submit' class='btn btn-primary'>로그인</button>
          </div>
        </form>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>닫기</button>
        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#RegisterModal' id='register'>회원가입</button>
        </div>
    </div>
  </div>
  <script>

$(document).ready(function(){
    // Show the Modal on load
    
    //로그인 창에서 회원가입 버튼 클릭시 로그인 창 숨기기.
    // Hide the Modal
    $('#register').click(function(){
        $('#LoginModal').modal('hide');
    });
});
</script>
</div>";


    //회원가입창
    echo"<div class='modal fade' id='RegisterModal' tabindex='-1' role='dialog' aria-labelledby='RegisterModalLabel' aria-hidden='true'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title' id='LoginModalLabel'>회원가입창</h4>
      </div>
      <div class='modal-body''>
        <form action='board_view.php' method='post'>
        <input type='hidden' name='user_mode' value='user_registry'>
          <div class='form-group'>
            <label for='id' class='control-label'>아이디</label>
            <input type='text' class='form-control' name='register_id'>
            <div id='id_alarm'></div>
          </div>
          <div class='form-group'>
            <label for='text' class='control-label'>비밀번호</label>
            <input type='text' class='form-control' name='register_password'>
            <div id='pw_alarm'></div>
             <label for='text' class='control-label'>비밀번호 재 확인</label>
            <input type='text' class='form-control' name='re_password'>
             <div id='re_alarm'></div>
            <button type='submit' class='btn btn-primary' id='insert_register'>회원가입 하기</button>
          </div>
        </form>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>닫기</button>
      </div>
    </div>
  </div>
  <script>
$(document).ready(function(){
     $('input[name=re_password]').prop('disabled', true);
     $('#insert_register').prop('disabled', true);
    $('input[name=register_id]').blur(function(){
        var input=$('input[name=register_id]').val();
        if(!input){
       $('#id_alarm').html('입력하세요');
       }
       else{
             $('#id_alarm').html('입력 완료.');
       }
    });
        $('input[name=register_password]').blur(function(){
        var pw=$('input[name=register_password]').val();
        if(!pw){
       $('#pw_alarm').html('입력하세요');
        $('input[name=re_password]').prop('disabled', true);
       }
       else{
             $('#pw_alarm').html('입력 완료.');
            $('input[name=re_password]').prop('disabled', false);
       }
    });
     $('input[name=re_password]').blur(function(){
        var input=$('input[name=register_id]').val();
        var pw=$('input[name=register_password]').val();
        var re=$('input[name=re_password]').val();
             if(pw==re){
                 $('#re_alarm').html('비밀번호 일치 확인.');
              if(input)   
             $('#insert_register').prop('disabled', false);
             }
             else{
                $('#re_alarm').html('비밀번호 불일치.');
                }
    });
});

</script>
</div>";
 /*   echo "<div class='form-horizontal'>";
    echo "<form class='form-group' action='board_view.php' method='post'>
                    <p class='col-sm-2 control-label'>ID</p>
                        <div class='col-sm-10'>
                            <input name='id' type='text' class='form-control'>
                        </div>
                    <p class='col-sm-2 control-label'>password</p>
                        <div class='col-sm-10'>
                            <input name='password' type='text' class='form-control'>
                        </div>
                        <input type='submit' class='btn btn-default' value='로그인'>
                      </form>";
    echo "</div>";*/
}
//로그인 확인
function check($id, $password)
{
    $result =  $this->model->login($id, $password);
    if ($result != 0) {
        session_destroy();
        session_start();
        session_regenerate_id();
        $s_id = session_id();
        //클라이언트 접속시 로그인 유지 관련 cookie에 대한 s_id 정보 DB저장.
        //microtime
        $expire = time() + 600;
        $this->model->put_login($id, $s_id, $expire);
        setcookie("cookie", $s_id, $expire, "/");
        echo "<script>location.replace('board_view.php')</script>";
    } else {
    echo" <script>alert('가입한 계정으로 로그인 해주세요')</script>";
      $this->login_window();
    }
}

//로그인 유지
function get_login(){
    $_SESSION['user']=$this->model->login_info();
   echo "<div class='btn-group'>";
    echo "<form style='display: inline' action='board_view.php' method='post'>";
    echo "<input type='hidden' name='user_mode' value='user_logout'>";
    echo "<button type='submit'  class='btn btn-primary'>로그아웃</button>";
    echo "</form>";
    echo "<form style='display: inline' action='board_view.php' method='post'>";
    echo "<input type='hidden' name='user_mode' value='user_info'>";
    echo "<button type='submit'  class='btn btn-primary'>개인 정보</button>";
    echo "</form>";
    echo "<form style='display: inline' action='board_view.php' method='post'>";
    echo "<input type='hidden' name='user_mode' value='user_delete'>";
    echo "<button type='submit'  class='btn btn-primary'>계정 탈퇴</button>";
    echo "</form>";
    echo "</div>";

    }
}
?>