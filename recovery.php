<?php
    session_start();
    require_once 'Database.php';
    require_once 'UserRepository.php';

    $db = new Database('localhost', 'eugene', 'Rr20092003', 'university_entrants');
    $userRepository = new UserRepository($db);

    if ($_POST) {
        $userRepository->passwordRecovery($_POST['login'], $_POST['secret_word'], $_POST['password'], $_POST['password_confirm']);
    }

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Восстановление пароля</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <form action="" method="post">
            <label>Логин</label>
            <input type="text" name="login" placeholder="Введите свой логин" required>
            <label>Секретное слово</label>
            <input type="password" name="secret_word" placeholder="Введите секретное слово для восстановления пароля" required>
            <label>Новый пароль</label>
            <input type="password" name="password" placeholder="Введите новый пароль" required>
            <label>Подтверждение нового пароля</label>
            <input type="password" name="password_confirm" placeholder="Подтвердите новый пароль" required>
            <button type="submit">Изменить пароль</button>
            <p>
                Вспомнили пароль? - <a href="/">Авторизоваться</a>!
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