<?php

    namespace Static\Requests;

    final class Users {

        public static function signUp() {
            $email = \Static\Kernel::getValue($_POST, "email");
            $username = \Static\Kernel::getValue($_POST, "username");
            $agree = \Static\Kernel::getValue($_POST, "agree");

            return array(
                "status" => \Static\Models\Users::signUp($email, $username, $agree),
            );
        }

        public static function logIn() {
            $email = \Static\Kernel::getValue($_POST, "email");
            $password = \Static\Kernel::getValue($_POST, "password");

            return array(
                "status" => \Static\Models\Users::logIn($email, $password),
            );
        }

        public static function reset() {
            $email = \Static\Kernel::getValue($_POST, "email");

            return array(
                "status" => \Static\Models\Users::reset($email),
            );
        }

        public static function update() {
            $email = \Static\Kernel::getValue($_POST, "email");
            $username = \Static\Kernel::getValue($_POST, "username");
            $confirm = \Static\Kernel::getValue($_POST, "confirm");

            return array(
                "status" => \Static\Models\Users::update($email, $username, $confirm),
            );
        }

        public static function change() {
            $password = \Static\Kernel::getValue($_POST, "password");
            $confirm = \Static\Kernel::getValue($_POST, "confirm");

            return array(
                "status" => \Static\Models\Users::change($password, $confirm),
            );
        }

        public static function isEmail() {
            $email = \Static\Kernel::getValue($_POST, "email");

            return array(
                "status" => \Static\Models\Users::isEmail($email),
            );
        }

        public static function isUsername() {
            $username = \Static\Kernel::getValue($_POST, "username");

            return array(
                "status" => \Static\Models\Users::isUsername($username),
            );
        }

        public static function isPassword() {
            $password = \Static\Kernel::getValue($_POST, "password");

            return array(
                "status" => \Static\Models\Users::isPassword($password),
            );
        }

        public static function logOut() {
            $_SESSION["userID"] = null;

            return array(
                "status" => "success",
            );
        }

    }

?>