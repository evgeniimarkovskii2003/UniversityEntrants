<?php
    session_start();
    require_once 'Database.php';
    require_once 'UserRepository.php';

    $db = new Database('localhost', 'eugene', 'Rr20092003', 'university_entrants');
    $userRepository = new UserRepository($db);

    if ($_POST) {
        $userRepository->signUp($_POST['login'], $_POST['email'], $_POST['password'], $_POST['password_confirm'], $_POST['secret_word']);
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Регистрация</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <form action="" method="post">
            <label>Логин</label>
            <input type="text" name="login" placeholder="Введите свой логин" required>
            <label>Почта</label>
            <input type="email" name="email" placeholder="Введите адрес своей почты" required>
            <label>Пароль</label>
            <input type="password" name="password" placeholder="Введите пароль" required>
            <label>Подтверждение пароля</label>
            <input type="password" name="password_confirm" placeholder="Подтвердите пароль" required>
            <label>Секретное слово</label>
            <input type="password" name="secret_word" placeholder="Введите секретное слово для восстановления пароля" required>
            <button type="submit">Зарегистрироваться</button>
            <p>
                У вас уже есть аккаунт? - <a href="/">Авторизоваться!</a>
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