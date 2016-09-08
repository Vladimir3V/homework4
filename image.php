<?php
require_once 'Connection.php';
/**
 * Created by PhpStorm.
 * User: vladimirvahrusev
 * Date: 04.09.16
 * Time: 21:12
 */
class Image
{
    /**
     * Удаляет файл
     * @param $imagename
     */
    public function delete_image($imagename)
    {
        if (isset($imagename)) {
            if (empty($imagename)) {
            } else {
                $db = new mysqli(
                    $GLOBALS['host'],
                    $GLOBALS['login'],
                    $GLOBALS['password'],
                    $GLOBALS['db_name']
                );
                if ($db->connect_errno) {
                    exit("ошибка подключения к БД, повторите запрос");
                }
                $sql = "DELETE FROM photos WHERE file = ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param('s', $imagename);
                $stmt->execute();
                $target_dir = "photos/";
                $target_old = $target_dir . basename($imagename);
                unlink($target_old);
            }
        }
    }

    /**
     * Переименовывает файл
     * @param $oldname
     * @param $newname
     */
    public function rename_file($oldname, $newname)
    {
        if (isset($oldname) || isset($newname)) {
            if (empty($oldname) || empty($newname)) {

            } else {
                $db = new mysqli(
                    $GLOBALS['host'],
                    $GLOBALS['login'],
                    $GLOBALS['password'],
                    $GLOBALS['db_name']
                );
                if ($db->connect_errno) {
                    exit("ошибка подключения к БД, повторите запрос");
                }

                $res = $db->query(
                    "select id from photos where file = '$oldname' "
                );
                $record = $res->fetch_assoc();

                $target_dir = "photos/";
                $target_old = $target_dir . basename($oldname);
                $target_new = $target_dir . basename($newname);

                rename($target_old, $target_new);

                $sql = "UPDATE photos SET file = ? WHERE id = ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param(
                    'si',
                    $newname,
                    $record ['id']
                );
                $stmt->execute();
            }
        }
    }

    /**
     *Функция добавляет изображение в папку и в базу
     * @param $img
     * @param $id
     * @param $postic
     */
    public function add_image_to_folder($img, $id, $postic)
    {
        if (isset($postic)) {
            $target_dir = "photos/";
            $target_file = $target_dir . basename($img["img"]["name"]);
            $status = true;
            $imageType = pathinfo($target_file, PATHINFO_EXTENSION);
            if ($target_file == $target_dir) {
                echo "Вы не выбрали файл ";
            } else {
                $check = getimagesize($img["img"]["tmp_name"]);
                if ($check !== false) {
                } else {
                    echo "Это не картинка ";
                    $status = false;
                }

                if (file_exists($target_file)) {
                    echo "Такой файл уже есть <br><br>";
                    $status = false;
                }

                if ($imageType != "jpg"
                    && $imageType != "png"
                    && $imageType != "jpeg"
                    && $imageType != "gif"
                ) {
                    echo "Вы можете загрузить только картинки <br> ";
                    $status = false;
                }

                $im = imagecreatetruecolor($check [0], $check [1]);
                $ooo = imagejpeg($im, $target_file, 100);
                if ($status) {
                    if (move_uploaded_file(
                        $img["img"]["tmp_name"],
                        $target_file
                    )
                    ) {
                        echo
                            "Файл "
                            . basename($img["img"]["name"])
                            . " был загружен <br><br>";

                        $db = new mysqli(
                            $GLOBALS['host'],
                            $GLOBALS['login'],
                            $GLOBALS['password'],
                            $GLOBALS['db_name']
                        );
                        if ($db->connect_errno) {
                            exit("ошибка подключения к БД, повторите запрос");
                        }
                        if (!$db->set_charset("utf8")) {
                            printf(
                                "Ошибка при загрузке набора символов utf8: %s\n",
                                $db->error
                            );
                        }


                        $sql = "INSERT INTO photos (user_id, file) VALUES(?, ?)";
                        $stmt = $db->prepare($sql);
                        $stmt->bind_param('is', $id, $img['img']['name']);
                        $stmt->execute();
                        $stmt->close();
                        $db->close();

                    }
                }
            }
        }
    }
}
