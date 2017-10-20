<?php
class login_model
{   private $dbconnect;
function  __construct()
{
    $this->dbconnect = mysqli_connect("127.0.0.1", "root", "autoset");
    mysqli_select_db($this->dbconnect, "test_board");
}
function __destruct()
{
    // TODO: Implement __destruct() method.
    mysqli_close($this->dbconnect);
}

//회원가입
    function register($obj)
    {
        $sql = "insert into client (id,password,level,age)";
        $sql .= "values('$obj->id','$obj->password','$obj->level',0)";
        mysqli_query($this->dbconnect, $sql);

    }
//회원탈퇴
    function delete_user()
    {
        $user=$_SESSION['user'];
        $sql = "delete from client where clientid=$user->clientid";
        mysqli_query($this->dbconnect, $sql);

    }
    function login($u_id, $u_password)
    {
        //DB 접속
        $sql = "select * from client where id=  '$u_id'  and password= '$u_password'";
        $result = mysqli_num_rows(mysqli_query($this->dbconnect, $sql));
        return $result;
    }

//sessionid,만료일자 설정.
    function put_login($id, $s_id, $expire)
    {

        //timestamp로 변환
        $expire = date('Y-m-d H:i:s', $expire);
        $sql = "update  client set sessionid='$s_id',checktime='$expire' where id='$id'";
        mysqli_query($this->dbconnect, $sql);

    }

//로그인 회원의 정보.
    function login_info()
    {
        $log = $_COOKIE['cookie'];

        $sql = "select * from client where sessionid = '$log'";
        //DB 고객 정보를 담은 객체 반환
        $result = mysqli_fetch_object(mysqli_query($this->dbconnect, $sql));

        return $result;
    }
}
?>