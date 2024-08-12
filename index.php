<?php
    session_start();
    require_once 'Database.php';
    require_once 'UserRepository.php';

    $db = new Database('localhost', 'eugene', 'Rr20092003', 'university_entrants');
    $userRepository = new UserRepository($db);

    if ($_POST) {
        $userRepository->signIn($_POST['login'], $_POST['password']);
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Авторизация и регистрация</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <form action="" method="post">
            <label>Логин</label>
            <input type="text" name="login" placeholder="Введите свой логин" required>
            <label>Пароль</label>
            <input type="password" name="password" placeholder="Введите пароль" required>
            <button type="submit">Войти</button>
            <p>
                У вас нет аккаунта? - <a href="/registration.php">Зарегистрироваться</a>!
            </p>
            <p>
                Забыли пароль? - <a href="/recovery.php">Восстановить пароль</a>!
            </p>
            <?php
            if ($_SESSION['msg']) {
                echo '<p class="msg"> '. $_SESSION['msg']. '</p>';
            }
            unset($_SESSION['msg']);
        ?>
        </form>
    </body>
</html>
