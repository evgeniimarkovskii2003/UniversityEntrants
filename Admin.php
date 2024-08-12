<?php
    class Admin extends User {
        private $position;

        public function __construct($id, $email, $login, $password, $secretWord, $role, $profile, $position) {
            parent::__construct($id, $email, $login, $password, $secretWord, $role, $profile);
            $this->position = $position;
        }

        public function getPosition() {
            return $this->position;
        }
    }
?>