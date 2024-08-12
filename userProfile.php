<?php
    session_start();
    require_once 'Database.php';
    require_once 'UserRepository.php';

    $db = new Database('localhost', 'eugene', 'Rr20092003', 'university_entrants');
    $userRepository = new UserRepository($db);

    if ($_POST) {
        $userRepository->fillingUserQuestionnaire($_SESSION['user']['id'], $_POST['name'], $_POST['passportData'], $_POST['scores']);
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Анкета пользователя</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <form action="" method="post">
            <label>ФИО</label>
            <input type="text" name="name" placeholder="Введите фамилию, имя, отчество" required>
            <label>Пасспортные данные</label>
            <input type="number" min="1000000000" max="9999999999" name="passportData" placeholder="Введите слитно серию и номер паспорта" required>
            <label>Балл</label>
            <input type="number" name="scores" min="140" max="300" placeholder="Введите полученный балл ЕГЭ по трем предметам" required>
            <button type="submit">Заполнить анкету</button>
            <p>
                Не хотите заполнять анкету? - <a href="/">Авторизация</a>!
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