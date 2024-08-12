<?php
    class User {
        private $id;
        private $email;
        private $login;
        private $password;
        private $secretWord;
        private $role;
        private $profile;

        public function __construct($id, $email, $login, $password, $secretWord, $role, $profile) {
            $this->id = $id;
            $this->email = $email;
            $this->login = $login;
            $this->password = $password;
            $this->secretWord = $secretWord;
            $this->role = $role;
            $this->profile = $profile;
        }

        public function getId() {
            return $this->id;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getLogin() {
            return $this->login;
        }

        public function getPassword() {
            return $this->password;
        }

        public function getSecretWord() {
            return $this->secretWord;
        }

        public function getRole() {
            return $this->role;
        }

        public function getProfile() {
            return $this->profile;
        }
    }
?>