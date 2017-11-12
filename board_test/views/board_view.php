<html>
<head>

    <link rel="stylesheet" href="../css/bootstrap.css">

    <style>
        body{
            width: 1000px;
            margin: 0 auto;
        }
    </style>
    <!--bootstrap 외부 자바스크립트-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
</head>
<body>
<!--로그인 부분-->
<div id="login">
 <?
 //사용자 객체 생성.

//$_server['document_root']==현재 폴더의 루트
 include $_SERVER['DOCUMENT_ROOT']."\board_test\controls\login_controller.php";
            $log_handler=new login_control();
            $log_handler->check_mode();


?>
<!--
<div>ID <input id='in_id' type=text'></div>
<div>PASSWORD <input id='in_password' type='text'></div>
<input type='button' value='로그인@' onclick='sending()'>-->
</div>
<input type='button' class='btn btn-info' value='전체계시판' onclick="location.replace('http://127.0.0.1:8080/board_test/views/board_view.php');">

    <!--글 목록 공간-->
<div id="middle">
    <?include $_SERVER['DOCUMENT_ROOT']."\board_test\controls\controller.php";
        $hendler=new control();
        $hendler->set_page();
   $page=$hendler->get_page();
    $hendler->create_list($page);

?>
</div>


</body>
</html>

