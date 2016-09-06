<?php
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 05.09.16
 * Time: 16:45
 */
session_start();
require_once 'get_data_form_db.php';
require_once 'add_user_info.php';
require_once 'image.php';

$b = new Add_User_Info;
$b->add_name_age_about(
    $_POST['Username'],
    $_POST['Password'],
    $_POST['Name'],
    $_POST['Age'],
    $_POST['About'],
    $_SESSION ['id']
);
$a = new Get_Data_Form_DB();
$a->get_info($_SESSION['id']);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
</head>
<body>
<div>
    <div >
        <form action="" method="post">
            <input type="submit"  value="Покниуть станицу" name="Logout">
        </form>
        <form action="" method="post">
            <p>Логин: <input title="" type="text" name="Username" value="<?php echo $_SESSION['username'] ?>" /></p>
            <p>Пароль: <input title="" type="text" name="Password" value="<?php echo $_SESSION['password'] ?>" /></p>
            <p>Имя: <input title="" type="text" name="Name" value="<?php echo $_SESSION['name'] ?>" /></p>
            <p>Возраст: <input title="" type="number" name="Age" value="<?php echo $_SESSION['age'] ?>" /></p>
            <p>О себе:</p>
            <p><textarea name="About" id="" cols="30" rows="10"><?php echo $_SESSION['about'] ?></textarea></p>
            <input type="submit" name="Login" value="Обновить данные" />
        </form>
        <br /><br />
        <form action="" method="post" enctype="multipart/form-data">
            Выберерте картинку для загрузки:
            <input type="file" name="img" id="img">
            <p><input type="submit" value="Загрузите файл" name="loadimage"></p>
        </form>
        <br />
        <p> Переимеовать файл</p>
        <form action="" method="post">
            <p>Старое имя файла: <input title="" type="text" name="OldName" /></p>
            <p> Новое имя файла: <input title="" type="text" name="NewName"  /></p>
            <input type="submit" name="nameupdae" value="Обновить имя файла" />
        </form>

        </form>
        <br />
        <p> Удалить файл</p>
        <form action="" method="post">
            <p>Имя файла для удаления: <input title="" type="text" name="DelFile" /></p>
            <input type="submit" name="deldel" value="Удалить файл" />
        </form>


    </div>
</div>

</body>
</html>

<?php

if (isset($_POST["Logout"])) {
    unset($_SESSION["id"]);
    session_destroy();
    echo '<script type="text/javascript">
                window.location = "index.html"
                </script>';
}

if (!isset($_SESSION['id'])) {
    echo '<script type="text/javascript">
                window.location = "index.html"
                </script>';
}

$c = new Image();
$c->add_image_to_folder($_FILES, $_SESSION['id'],$_POST['loadimage']);

$c->rename_file($_POST['OldName'], $_POST['NewName']);

$c->delete_image($_POST['DelFile']);

echo 'Список файлов в папке с фотографиями: <br>';
$dir = scandir('photos/');
foreach ($dir as $key) {
    if ($key == '.' || $key == '..' ) {
    } else {
        echo $key, '<br>';
    }
}
?>

