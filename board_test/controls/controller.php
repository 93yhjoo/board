
<?php
include $_SERVER['DOCUMENT_ROOT']."\board_test\models\model.php";
const size_page = 10;

class control{
    private $page;
function __construct(){
    $this->page=1;
}
function set_page(){
    if(isset($_GET["page"])) {
        $this->page = $_GET['page'];
    }
}
function get_page(){
    return $this->page;
}



//목록생성
function create_list($page_arg){
    if (isset($_GET['select_box']) ) {
        $_SESSION['mode']=2;
        $first=$_GET['select_box'];
        $second=$_GET['search'];
        $_SESSION['where']="../views/board_view.php?select_box=$first&search=$second&";
}
else{
    $_SESSION['mode']=1;
    $_SESSION['where']="../views/board_view.php?&";
    }
    $total_page = pagenation();
    $current_page = $this->page;
    $pre = $current_page - 1;
    $top=($current_page-1)*size_page;
    $row = running_sql($top);
    echo "<div id='top'>";
    echo "<table class='table table-hover'>
        <tr><th colspan='4'>게시판</th></tr>
        <tr>
            <td>글 제목</td>
            <td>작성자</td>
            <td>조회수</td>
            <td>생성 날짜</td>       
        </tr>";

    for ($i = 0; $i < size_page; $i++) {
        try {
            $record = mysqli_fetch_row($row);
            echo "<tr>";
            if($record[2]!=0){
                $string="";
                for($j=1;$j<$record[3];$j++){
                    $string.="&raquo;&raquo;";
                }
                echo "<td>$string RE <a href='../views/view_subject.php?board_id=$record[0]'>" . $record[5] . "</a></td>";
            }else{
                echo "<td>$record[0]&nbsp;<a href='../views/view_subject.php?board_id=$record[0]'>" . $record[5] . "</a></td>";
            }
            echo "<td>" . $record[4] . "</td>";
            echo "<td>" . $record[7] . "</td>";
            echo "<td>" . $record[8] . "</td>";
            echo "</tr>";
        } catch (Exception $e) {
            break;
        }
    }
    echo "</table></div>";

    echo "<div>";

        echo "<nav>
  <ul class='pagination'>";
        if ($pre != 0) {
            $ref=$_SESSION['where'];
            $ref.="page=$pre";
            echo "<li class='active'><a href='$ref' >&laquo;</a></li>";
        }
        if($total_page>size_page) {
            if ($current_page < 3) {
                for ($i = 1; $i <= size_page; $i++) {
                    if ($i == $current_page)
                        echo "<li class='disabled'><a>" . ($i) . "</a></li>";
                    else {
                        $ref = $_SESSION['where'];
                        $ref .= "page=$i";
                        echo "<li class='active'><a href=$ref>" . ($i) . "</a></li>";
                    }
                }
            }
            if ($current_page < $total_page - 1 && $current_page >= size_page/2+1) {
                for ($i = $current_page - 2; $i < $current_page +(size_page/2+1); $i++) {
                    if ($i == $current_page)
                        echo "<li class='disabled'><a>" . ($i) . "</a></li>";
                    else {
                        $ref = $_SESSION['where'];
                        $ref .= "page=$i";
                        echo "<li class='active'><a href=$ref>" . ($i) . "</a></li>";
                    }
                }
            }
            if ($current_page >= $total_page - 1) {
                for ($i = $total_page - 4; $i < $total_page + 1; $i++) {
                    if ($i == $current_page)
                        echo "<li class='disabled'><a>" . ($i) . "</a></li>";
                    else {
                        $ref = $_SESSION['where'];
                        $ref .= "page=$i";
                        echo "<li class='active'><a href=$ref>" . ($i) . "</a></li>";
                    }
                }
            }
        }
        if($total_page<size_page){
            for ($i = 1; $i <= $total_page; $i++) {
                if ($i == $current_page)
                    echo "<li class='disabled'><a>" . ($i) . "</a></li>";
                else {
                    $ref = $_SESSION['where'];
                    $ref .= "page=$i";
                    echo "<li class='active'><a href=$ref>" . ($i) . "</a></li>";
                }
            }
        }
        $far = $current_page + 1;
        if ($far <= $total_page) {
            $ref=$_SESSION['where'];
            $ref.="page=$far";
            echo "<li class='active'><a href='$ref' >&raquo;</a></li>";
        }
        echo "</ul></nav>";
        echo "</div>";

    //만일 접속해 있다면 글쓰기 창 보이기
    if(isset($_COOKIE['cookie'])) {
        echo "<div>";
        echo "<form action='../views/view_subject.php' method='post'>
            <input type='hidden' name='mode' value='write'>
            <input type='submit'  class='btn btn-default' value='글쓰기'>
            </form>";
        echo "</div>";
    }
    //검색창
    echo "<form action='../views/board_view.php' method='get'>";
    echo "<select name='select_box' class='form-control input-sm'>";
    echo "  <option value='writer_id'>작성자</option>";
    echo "  <option value='subject'>제목</option>";
    echo "  <option value='contents'>내용</option>";
    echo "  <option value='all'>작성자+제목+내용</option>";
    echo "</select>";
    echo "<input name='search' type='text'>";
    echo "<input type='submit' value='검색하기'>";
    echo "</form>";
}
}
?>


