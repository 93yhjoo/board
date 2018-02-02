<?php

?>
<html>
<head>
    <style>
        body{
            width: 1000px;
            margin: 0 auto;
        }
    </style>
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


<div id="main">
    <?php
    foreach ($list as $lt):
   ?>
    <table class='table table-bordered'>
        <tr><th colspan='0'><p style='text-align: center'><?echo $lt->subject?></p></th></tr>
        <tr><td>
                <h6>작성자 <?echo $lt->writer_id?></h6>
                <h6>작성일 <?echo $lt->reg_date?></h6>
        </td></tr>
        <tr><td>
                <h3><?echo $lt->file_path;?></h3>

                <?
                if($lt->file_path!=null):
                ?>
                <form action="<?php echo base_url('index.php/product_controller/buy');?>" method="post">
                    <input type="hidden" name="board_id" value="<?php echo $lt->board_id;?>">
                    <input type="submit" value="구입">
                </form>    
                <?
                    endif;
                    ?>
                <?
                echo $lt->contents.'<br>';
                ?>
        </td></tr>
    </table>
    <?endforeach;?>
    <?php
//코멘트 영역

    ?>
</div>
<div id="footer">
    <?echo anchor('index.php','글목록','class="btn btn-primary"');?>


</div>


</body>
</html>
