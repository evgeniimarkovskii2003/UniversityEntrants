<?php
    session_start();
    require_once 'Database.php';
    require_once 'UserRepository.php';

    $db = new Database('localhost', 'eugene', 'Rr20092003', 'university_entrants');
    $userRepository = new UserRepository($db);

    $connect = $db->connect();
    $check_user = $connect->prepare("SELECT userName FROM `userquestionnaire` WHERE `userID` =?");
    $check_user->bind_param("i", $_SESSION['user']['id']);
    $check_user->execute();
    $result = $check_user->get_result();
    $user_data = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Страница пользователя</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <div class="logout-container">
            <a href="/logout.php" class="logout">Выход</a>
        </div>
        <div class="welcome-container">
            <h1 class="welcome-text">Здравствуйте, <?php echo $user_data['userName']. '!';?></h1>
            <p class="status-text">Ваша заявка на поступление принята!</p>
        </div>
        <?php
        if ($_SESSION['msg']) {
            echo '<p class="msg"> '. $_SESSION['msg']. '</p>';
        }
        unset($_SESSION['msg']);
    ?>
    </body>
</html>
