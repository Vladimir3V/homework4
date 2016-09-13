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

if (!isset($_SESSION['id'])) {
    echo '<script type="text/javascript">
              window.location = "index.html"
          </script>';
}

$b = new AddUserInfo;
$b->addNameAgeAbout($_POST, $_SESSION ['id']);
$b->delUser($_POST['DeletUser'], $_SESSION ['id']);
$a = new GetDataFormDB();
$a->getInfo($_SESSION['id']);

$dir = scandir('photos/');
echo '<br>';
foreach ($dir as $key => $value) {
    if ($value   == '.'
        || $value  == '..'
        || $value  == '.DS_Store'
    ) {

        unset($dir[$key]);
    }
}

$c = new Image();
$c->createFolder();
$c->addImageToFolder($_FILES, $_SESSION['id'], $_POST['loadimage']);
$c->deleteImage($_POST['DelFile']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF8">
    <title>Личный кабинет</title>
</head>
<body>
<div>
    <div>
        <form action="" method="post">
            <input type="submit"  value="Покниуть станицу" name="Logout">
        </form>
        <form action="" method="post">
            <p>
                Логин:
                <input
                    title=""
                    type="text"
                    name="Username"
                    value="<?php echo $_SESSION['username'] ?>"/>
            </p>
            <p>Пароль:
                <input
                    title=""
                    type="text"
                    name="Password"
                    value="<?php echo $_SESSION['password'] ?>" />
            </p>
            <p>
                Имя:
                <input
                    title=""
                    type="text"
                    name="Name"
                    value="<?php echo $_SESSION['name'] ?>" />
            </p>
            <p>
                Возраст:
                <input title=""
                       type="number"
                       name="Age"
                       value="<?php echo $_SESSION['age'] ?>" />
            </p>
            <p>О себе:</p>
            <p>
                <textarea
                    title=""
                    name="About"
                    id=""
                    cols="30"
                    rows="10"
                ><?php echo $_SESSION['about'] ?></textarea>
            </p>
            <input type="submit" name="Login" value="Обновить данные" />
        </form>
        <form action="" method="post">
            <input type="submit" name="DeletUser" value="Удалить аккаунт" />

        </form>
        <br /><br />
        <form action="" method="post" enctype="multipart/form-data">
            Выберерте картинку для загрузки:
            <input type="file" name="img" id="img">
            <p><input type="submit" value="Загрузите файл" name="loadimage"></p>
        </form>
    </div>
</div>
Список файлов в папке с фотографиями:
</div>
<table>
    <tr>
        <th>Название файла</th>
        <th>Управление</th>
    </tr>
    <?php foreach($dir as $key => $value) :?>
        <tr>
            <td>
                <div>
                    <?php echo $value; ?>
                </div>
            </td>
            <td>
                <form action="newname.php" method="post">
                    <button
                        type  = "submit"
                        name  = "OldName"
                        value = "<?php echo $value; ?>"
                    >Переименовать</button>
                </form>
            </td>
            <td>
                <form action="" method="post">
                    <button
                        type  = "submit"
                        name  = "DelFile"
                        value = "<?php echo $value; ?>"
                    >Удалить файл</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
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
?>








