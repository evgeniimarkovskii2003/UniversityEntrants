<?php
    class UserRepository {
        private $db;

        public function __construct(Database $db) {
            $this->db = $db;
        }

        public function signUp($login, $email, $password, $passwordConfirm, $secretWord) {
            $connect = $this->db->connect();
            $stmt = $connect->prepare("SELECT * FROM logindetails WHERE login =? OR email =?");
            $stmt->bind_param("ss", $login, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['msg'] = "Такой логин или email уже существует";
                header('Location:../registration.php');
                exit;
            } else {
                if (strlen($password) >= 8 && strlen($password) <= 30 && strlen($secretWord) >= 8 && strlen($secretWord) <= 30 && strlen($login) >= 3 && strlen($login) <= 20) {
                    if ($password == $passwordConfirm) {
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $secretWord = password_hash($secretWord, PASSWORD_DEFAULT);

                        $stmt = $connect->prepare("INSERT INTO logindetails (email, login, password, secretWord, role, profile) VALUES (?,?,?,?,?,?)");
                        $role = 'User';
                        $profile = 0;
                        $stmt->bind_param("sssssi", $email, $login, $password, $secretWord, $role, $profile);
                        $stmt->execute();

                        $_SESSION['msg'] = 'Регистрация прошла успешно!';
                        header('Location:../index.php');
                        exit;
                    } else {
                        $_SESSION['msg'] = "Пароли не совпадают";
                        header('Location:../registration.php');
                        exit;
                    }
                } else {
                    $_SESSION['msg'] = "Длина пароля и секретного слова должны быть от 8 до 30 символов. Длина логина от 3 до 20 символов.";
                    header('Location:../registration.php');
                    exit;
                }
            }
        }

        public function signIn($login, $password) {
            $connect = $this->db->connect();
            $stmt = $connect->prepare("SELECT * FROM logindetails WHERE login =?");
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        "id" => $user['userID'],
                        "email" => $user['email'],
                        "profile" => $user['profile'],
                    ];
                    if ($user['profile'] && $user['role'] == 'User') {
                        header('Location:../pageUsers.php');
                        exit;
                    } elseif ($user['profile'] === 0 && $user['role'] == 'User') {
                        header('Location:../userProfile.php');
                        exit;
                    } elseif ($user['profile'] && $user['role'] == 'Admin') {
                        header('Location:../pageAdmins.php');
                        exit;
                    } else {
                        header('Location:../adminProfile.php');
                        exit;
                    }
                } else {
                    $_SESSION['msg'] = 'Неверный логин или пароль';
                    header('Location:../index.php');
                    exit;
                }
            } else {
                $_SESSION['msg'] = 'Неверный логин или пароль';
                header('Location:../index.php');
                exit;
            }
        }

        public function passwordRecovery($login, $secretWord, $password, $passwordConfirm) {
            $connect = $this->db->connect();
            $stmt = $connect->prepare("SELECT * FROM logindetails WHERE login =?");
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                if (password_verify($secretWord, $user['secretWord'])) {
                    if ($password === $passwordConfirm) {
                        $stmt = $connect->prepare("UPDATE logindetails SET password =? WHERE login =?");
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                        $stmt->bind_param("ss", $passwordHash, $login);
                        $stmt->execute();
                        $_SESSION['msg'] = 'Пароль успешно изменен';
                        header('Location:../index.php');
                        exit;
                    } else {
                        $_SESSION['msg'] = 'Пароли не совпадают';
                        header('Location:../recovery.php');
                        exit;
                    }
                } else {
                    $_SESSION['msg'] = 'Неверное секретное слово';
                    header('Location:../recovery.php');
                    exit;
                }
            } else {
                $_SESSION['msg'] = 'Неверный логин';
                header('Location:../recovery.php');
                exit;
            }
        }

        public function logout() {
            unset($_SESSION['user']);
            header('Location:../index.php');
            exit;
        }

        public function fillingUserQuestionnaire($id, $name, $passportData, $scores) {
            $connect = $this->db->connect();
            $stmt = $connect->prepare("INSERT INTO userquestionnaire (userID, userName, passportData, scores) VALUES (?,?,?,?)");
            $stmt->bind_param("isss", $id, $name, $passportData, $scores);
            $stmt->execute();
            $stmt = $connect->prepare("UPDATE logindetails SET profile =? WHERE userID=?");
            $profile = 1;
            $stmt->bind_param("ii", $profile, $id);
            $stmt->execute();
            $_SESSION['msg'] = 'Данные успешно внесены';
            header('Location:../pageUsers.php');
            exit;
        }

        public function fillingAdminQuestionnaire($id, $name, $passportData, $position) {
            $connect = $this->db->connect();
            $stmt = $connect->prepare("INSERT INTO adminquestionnaire (adminID, adminName, passportData, position) VALUES (?,?,?,?)");
            $stmt->bind_param("isss", $id, $name, $passportData, $position);
            $stmt->execute();
            $stmt = $connect->prepare("UPDATE logindetails SET profile =? WHERE userID=?");
            $profile = 1;
            $stmt->bind_param("ii", $profile, $id);
            $stmt->execute();
            $_SESSION['msg'] = 'Данные успешно внесены';
            header('Location:../pageAdmins.php');
            exit;
        }
    }
?>