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

        <tr><th colspan='6'>구매내역</th></tr>
        <tr>
            <td>이름</td>
            <td>판매자</td>
            <td>가격</td>
            <td>미리듣기</td>
            <td>다운로드</td>
            <td>구입 날짜</td>
        </tr>
        <tbody>
        <?php
        foreach ($list as $lt):
            ?>
            <tr>
                <td><?php echo $lt->buyer_id;?></td>
                <td><?php echo $lt->writer_id;?></td>
                <td><?php echo $lt->price;?></td>
                <td><h6>미리듣기 위치</h6></td>
                <td><a href="<?php echo base_url($lt->file_path);?>">다운로드</a></td>
                <td><?php echo $lt->buy_date;?></td>
            </tr>
            <?php
        endforeach;
        ?>
        </tbody>
    </table>
</div>


</body>
</html>
