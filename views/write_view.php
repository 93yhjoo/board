<html>
<div>

    <?php echo $error;?>

    <?php echo form_open_multipart(base_url('index.php/main_controller/submit'));?>

    <input type="file" name="uploadfile[]"/>

    <br/><br/>
    <P>작성자<input type="text" placeholder="<?echo $_SESSION['uid']?>"></P>
    <p>제목<input type='text' name='subject'/></p>
    <p>내용</p>
    <textarea style='width:220px;height:340px;resize:none;' name='contents'><?php echo set_value('contents',""); ?></textarea>
    <div>
        <input type='submit' class='btn btn-primary' value='제출'>
    </div>
</form>
</div>

</html>