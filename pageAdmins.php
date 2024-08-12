<?php
    session_start();
    require_once 'Database.php';
    require_once 'UserRepository.php';

    $db = new Database('localhost', 'eugene', 'Rr20092003', 'university_entrants');
    $userRepository = new UserRepository($db);

    $connect = $db->connect();
    $limit = 8;
    $page = isset($_GET['page'])? $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $check_users = $connect->prepare("SELECT COUNT(*) FROM `userquestionnaire`");
    $check_users->execute();
    $result = $check_users->get_result();
    $total_rows = $result->fetch_assoc()['COUNT(*)'];

    $total_pages = ceil($total_rows / $limit);

    $check_users = $connect->prepare("SELECT * FROM `userquestionnaire` ORDER BY `scores` DESC LIMIT $offset, $limit");
    $check_users->execute();
    $result = $check_users->get_result();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Страница админа</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Пасспортные данные</th>
                    <th>Балл</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()):?>
                <tr>
                    <td><?php echo $row['userID'];?></td>
                    <td><?php echo $row['userName'];?></td>
                    <td><?php echo $row['passportData'];?></td>
                    <td><?php echo $row['scores'];?></td>
                </tr>
                <?php endwhile;?>
            </tbody>
        </table>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++):?>
            <a href="?page=<?php echo $i;?>" <?php if ($i == $page) echo 'class="active"';?>><?php echo $i;?></a>
            <?php endfor;?>
        </div>
        <div>
            <a href="/logout.php" class="logout">Выход</a>
        </div>
    </body>
</html>