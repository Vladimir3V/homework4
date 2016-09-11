
<html>
    <form action="" method="post">
        <p>
            Введите новое имя для файла "<?php echo $_POST['OldName']?>"
            <br>
            <input
                title=""
                type="text"
                name="NewName"
                value=""/>
        </p>
        <input type="submit" name="nameupdae" value="Обновить имя файла" />
    </form>
    <a href="main2.php">Вернуться в кабинет</a>


</html>

<?php
session_start();
require_once 'image.php';
require_once 'get_data_form_db.php';
require_once 'add_user_info.php';

if (!isset($_SESSION['id'])) {
    echo '<script type="text/javascript">
              window.location = "index.html"
          </script>';
}
if (($_POST['OldName']) != null) {
    $_SESSION['OldName'] = $_POST['OldName'];
}

$a = new Image();
$a->renameFile($_SESSION['OldName'], $_POST['NewName']);


?>
