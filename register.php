<?php
session_start();
if (isset($_SESSION['id'])) {
    echo '<script type="text/javascript">
    window.location = "index.html"
</script>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистарция</title>
</head>
<body>
    <div>
        <form action="" method="post">
            <div> Логин     <input title="" type="text" name="u_login">     </div>
            <div> Пароль  <input title="" type="text" name="u_password">  </div>
            <div> Повторите пароль <input title="" type="text" name="u_password2">  </div>
            <button type="submit" id="button" > Зарегистрироваться </button>
            <a href="index.html"> Войти </a>
        </form>
    </div>

    <script src="https://yastatic.net/jquery/3.1.0/jquery.js"></script>
    <script>
        $(document).ready(function () {
            $('#button').on('click', function () {
                $.ajax({
                    type : 'post',
                    url  : 'first.php',
                    data : {
                        reg_login : $('input[name=u_login]').val(),
                        reg_password : $('input[name=u_password]').val(),
                        reg_password2 : $('input[name=u_password2]').val()
                    },
                    success : function (data) {

                        console.log(data);

                        if (data == 2) {
                            setTimeout(function() {
                                alert('Регитсрация прошла успешно');
                            }, 1);
                            window.location.href='main2.php';


                        } else {
                            alert(data);
                        }
                    }
                });
                return false;
            });
        });
    </script>

</body>
</html>