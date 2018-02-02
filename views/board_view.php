<?php
/**
 * Created by PhpStorm.
 * User: joo
 * Date: 2018-01-23
 * Time: 오후 4:28
 */
?>
<html>
<body>
<div id='top'>
    <table class='table table-hover'>

        <tr><th colspan='4'>게시판</th></tr>
        <tr>
            <td>글 제목</td>
            <td>작성자</td>
            <td>조회수</td>
            <td>생성 날짜</td>
        </tr>
        <tbody>
        <?php
        foreach ($list as $lt):
            ?>
            <tr>
                <?
                    if($lt->grpord!=0){
                        $str="";
                        for($j=1;$j<$lt->depth;$j++){
                            $str.="&raquo;&raquo;";
                        }
                        echo "<td>$str RE ";
                        echo anchor('/index.php/main_controller/view/'.$lt->board_id,$lt->subject);
                        echo "</td>";

                    }else{ echo "<td>";
                        echo anchor('/index.php/main_controller/view/'.$lt->board_id,$lt->subject);
                        echo "</td>";
                    }
                ?>
                <td><?php echo $lt->writer_id?></td>
                <td><?php echo $lt->hits?></td>
                <td><?php echo $lt->reg_date?></td>
            </tr>
            <?php
        endforeach;
        ?>

        </tbody>
    </table>
    <tr>
        <th colspan=5><?php echo $pagination; ?></th>
    </tr>
</div>
<div>
    <form action='board_view.php' method='get'>
        <select name='select_box' class='form-control input-sm'>
              <option value='writer_id'>작성자</option>
            <option value='subject'>제목</option>
              <option value='contents'>내용</option>
              <option value='all'>작성자+제목+내용</option>
            </select>
        <input name='search' type='text'>
        <input type='submit' class="btn btn-default navbar-btn" value='검색하기'>
        </form>
</div>
<?
if(isset($_COOKIE['cookie'])):
?>
    <div>
        <?echo anchor('index.php/main_controller/write','글쓰기','class="btn btn-primary"');?>
    </div>
<?endif;?>
</body>
</html>
