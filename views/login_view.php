
<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="<?echo  base_url("css/bootstrap.css");?>">
    <style>
        body{
            width: 1000px;
            margin: 0 auto;
        }
    </style>
    <!--bootstrap 외부 자바스크립트-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="<?echo base_url("js/bootstrap.js")?>"></script>
<?
if(!isset($_COOKIE['cookie'])):
?>
</head>
<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#LoginModal'>로그인</button>
<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#RegisterModal'>회원가입</button>

<!--로그인 창-->
<div class='modal fade' id='LoginModal' tabindex='-1' role='dialog' aria-labelledby='LoginModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <h4 class='modal-title' id='LoginModalLabel'>로그인창</h4>
            </div>
            <div class='modal-body''>
            <!--로그인 팝업 창-->
            <form action='<?echo base_url("index.php/login_controller/login_u")?>' method='post'>
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
</div>


<!--회원가입 창-->
<div class='modal fade' id='RegisterModal' tabindex='-1' role='dialog' aria-labelledby='RegisterModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <h4 class='modal-title' id='LoginModalLabel'>회원가입창</h4>
            </div>
            <div class='modal-body''>
            <!--회원 가입 form-->
            <form action='<?echo base_url("index.php/login_controller/register_user")?>' method='post'>
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
                $('#insert_register').prop('disabled', true);
            }
        });
    });

</script>
</div>
</html>
<?php else:?>
<div class='btn-group'>
    <a href="<?echo base_url('index.php/login_controller/logout')?>" class='btn btn-primary'>로그아웃</a>
    <a href="<?echo base_url('index.php/login_controller/resign')?>" class='btn btn-primary'>계정 탈퇴</a>
    <a href="<?echo base_url('index.php/product_controller/show_history')?>" class='btn btn-primary'>계정 정보</a>
</div>
<?php endif;?>
<div class='btn-group'>
    <a href="<?echo base_url('index.php/main_controller/lists')?>" class='btn btn-primary'>통합게시판</a>
</div>
