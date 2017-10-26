<html>
<head>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <style>
        body{
            width: 1000px;
            margin: 0 auto;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script>
      function create_dash(arg_bid,argcid) {
            var address="view_subject.php?board_id="+arg_bid;
                var space=document.getElementsByName(argcid);
                space[0].innerHTML="<form action='"+address+"' method='post'>" +
                    "<textarea name='comment' class='form-control' rows='3' style='resize:none' ></textarea>"
            +"<input type='hidden' name='comment_id' value="+argcid+">"
                    +"<input class='btn btn-default' type='submit' value='등록'>"+"</form>"

        }
    </script>
</head>
<body>
<div id="login">
    <? include $_SERVER['DOCUMENT_ROOT']."\board_test\controls\login_controller.php";
    $log_handler=new login_control();
    $log_handler->check_mode();
    ?>
</div>

<div id="main">
<?php

include $_SERVER['DOCUMENT_ROOT']."\board_test\controls\subject_controller.php";
$subject_handler=new subject_control();
if(!isset($_POST['mode'])) {
    $board_id = $_GET["board_id"];
    $subject_handler->show_record($board_id);

//코멘트 영역
    include $_SERVER['DOCUMENT_ROOT']."\board_test\controls\comment_controller.php";
$comment_handler=new comment_control();
    //댓글 등록시 DB에 등록
    if (isset($_POST['comment'])) {
        $comment_handler->input_comment($board_id, $_POST['comment']);
    }
    $comment_handler->comment_table($board_id);
    //로그인 시 댓글 등록창 활성화
    $comment_handler->confirm($board_id);

}
else{
    $subject_handler->situation($_POST['mode']);
}

?>
</div>
<div id="footer">
    <input type='button' class='btn btn-info' value='글목록' onclick="location.replace('http://127.0.0.1/board_view.php');">
</div>


</body>
</html>