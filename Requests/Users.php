<?php

    namespace Static\Requests;

    final class Users {

        public static function signUp() {
            $email = \Static\Kernel::getValue($_POST, "email");
            $username = \Static\Kernel::getValue($_POST, "username");
            $agree = \Static\Kernel::getValue($_POST, "agree");

            return \Static\Kernel::getRequest(\Static\Models\Users::signUp($email, $username, $agree));
        }

        public static function logIn() {
            $email = \Static\Kernel::getValue($_POST, "email");
            $password = \Static\Kernel::getValue($_POST, "password");

            return \Static\Kernel::getRequest(\Static\Models\Users::logIn($email, $password));
        }

        public static function reset() {
            $email = \Static\Kernel::getValue($_POST, "email");

            return \Static\Kernel::getRequest(\Static\Models\Users::reset($email));
        }

        public static function search() {
            $search = \Static\Kernel::getValue($_POST, "search");

            return \Static\Kernel::getRequest(\Static\Models\Users::search($search));
        }

        public static function update() {
            $email = \Static\Kernel::getValue($_POST, "email");
            $username = \Static\Kernel::getValue($_POST, "username");
            $language = \Static\Kernel::getValue($_POST, "language");
            $confirm = \Static\Kernel::getValue($_POST, "confirm");

            return \Static\Kernel::getRequest(\Static\Models\Users::update($email, $username, $language, $confirm));
        }

        public static function notifications() {
            $notifications = json_encode([
                "message" => \Static\Kernel::getValue($_POST, "message"),
                "published" => \Static\Kernel::getValue($_POST, "published"),
            ]);
            $confirm = \Static\Kernel::getValue($_POST, "confirm");

            return \Static\Kernel::getRequest(\Static\Models\Users::notifications($notifications, $confirm));
        }

        public static function others() {
            $others = json_encode([
                "languages" => \Static\Kernel::getValue($_POST, "languages"),
                "contact" => \Static\Kernel::getValue($_POST, "contact"),
            ]);
            $confirm = \Static\Kernel::getValue($_POST, "confirm");

            return \Static\Kernel::getRequest(\Static\Models\Users::others($others, $confirm));
        }

        public static function change() {
            $password = \Static\Kernel::getValue($_POST, "password");
            $confirm = \Static\Kernel::getValue($_POST, "confirm");

            return \Static\Kernel::getRequest(\Static\Models\Users::change($password, $confirm));
        }

        public static function delete() {
            $confirm = \Static\Kernel::getValue($_POST, "confirm");

            return \Static\Kernel::getRequest(\Static\Models\Users::delete($confirm));
        }

        public static function isEmail() {
            $email = \Static\Kernel::getValue($_POST, "email");

            return \Static\Kernel::getRequest(\Static\Models\Users::isEmail($email));
        }

        public static function isUsername() {
            $username = \Static\Kernel::getValue($_POST, "username");

            return \Static\Kernel::getRequest(\Static\Models\Users::isUsername($username));
        }

        public static function isPassword() {
            $password = \Static\Kernel::getValue($_POST, "password");

            return \Static\Kernel::getRequest(\Static\Models\Users::isPassword($password));
        }

        public static function logOut() {
            $_SESSION["userID"] = null;

            return \Static\Kernel::getRequest("success");
        }

    }

?>