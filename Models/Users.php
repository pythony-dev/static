<?php

    namespace Static\Models;

    use PDO;

    final class Users extends Database {

        public static function signUp($email, $username, $agree) {
            $email = htmlspecialchars($email);
            $username = htmlspecialchars($username);

            if(self::isEmail($email) != "success") return "email";
            else if(self::isUsername($username) != "success") return "username";
            else if($agree != "true") return "agree";

            $password = self::createPassword();

            $query = parent::$pdo->prepare("INSERT INTO Users (created, email, username, password, reset) VALUES (NOW(), :email, :username, :password, NULL)");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":password", sha1($password . \Static\Kernel::getSalt()), PDO::PARAM_STR);

            $title = \Static\Languages\Translate::getText("emails-signUp-title");
            $content = \Static\Languages\Translate::getText("emails-signUp-content", true, array(
                "log-in" => \Static\Kernel::getPath("/log-in"),
                "settings" => \Static\Kernel::getPath("/settings"),
                "user-email" => $email,
                "user-password" => $password,
            ));

            return $query->execute() && copy("Public/Images/Users/0.jpeg", "Public/Images/Users/" . parent::$pdo->lastInsertId() . ".jpeg") && \Static\Emails::send($email, $title, $content) ? "success" : "error";
        }

        public static function logIn($email, $password) {
            $email = htmlspecialchars($email);
            $password = sha1(htmlspecialchars($password) . \Static\Kernel::getSalt());

            if(empty($email)) return "email";
            else if(empty($password)) return "password";

            $query = parent::$pdo->prepare("SELECT id, password, reset FROM Users WHERE email = :email");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->execute();

            if(!($results = $query->fetch())) return "email";

            $id = (int)$results["id"];

            if($id < 1) return "email";
            else if($results["password"] == $password) {
                $_SESSION["userID"] = $id;

                $query = parent::$pdo->prepare("UPDATE Users SET reset = NULL WHERE id = :id");
                $query->bindValue(":id", $id, PDO::PARAM_INT);

                return $query->execute() ? "success" : "error";
            } else if($results["reset"] == $password) {
                $_SESSION["userID"] = $id;

                $query = parent::$pdo->prepare("UPDATE Users SET password = reset, reset = NULL WHERE id = :id");
                $query->bindValue(":id", $id, PDO::PARAM_INT);

                return $query->execute() ? "success" : "error";
            } else return "password";
        }

        public static function reset($email) {
            $email = htmlspecialchars($email);

            if(self::isEmail($email) != "used") return "email";

            $reset = self::createPassword();

            $query = parent::$pdo->prepare("UPDATE Users SET reset = :reset WHERE email = :email");
            $query->bindValue(":reset", sha1($reset . \Static\Kernel::getSalt()), PDO::PARAM_STR);
            $query->bindValue(":email", $email, PDO::PARAM_STR);

            $title = \Static\Languages\Translate::getText("emails-reset-title");
            $content = \Static\Languages\Translate::getText("emails-reset-content", true, array(
                "log-in" => \Static\Kernel::getPath("/log-in"),
                "settings" => \Static\Kernel::getPath("/settings"),
                "user-email" => $email,
                "user-password" => $reset,
            ));

            return $query->execute() && \Static\Emails::send($email, $title, $content) ? "success" : "error";
        }

        public static function getUser() {
            $id = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($id < 1) return array();

            $query = parent::$pdo->prepare("SELECT id, email, username FROM Users WHERE id = :id");
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch();
        }

        public static function update($email, $username, $confirm) {
            $email = htmlspecialchars($email);
            $username = htmlspecialchars($username);
            $confirm = sha1(htmlspecialchars($confirm) . \Static\Kernel::getSalt());

            $id = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($id < 1) return "user";
            else if(self::isEmail($email) != "success") return "email";
            else if(self::isUsername($username) != "success") return "username";

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE id = :id AND password = :confirm");
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!$query->fetch()) return "confirm";

            $query = parent::$pdo->prepare("UPDATE Users SET email = :email, username = :username WHERE id = :id");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":id", $id, PDO::PARAM_INT);

            return $query->execute() ? "success" : "error";
        }

        public static function change($password, $confirm) {
            $id = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($id < 1) return "user";
            else if(self::isPassword($password) != "success") return "password";

            $password = sha1(htmlspecialchars($password) . \Static\Kernel::getSalt());
            $confirm = sha1(htmlspecialchars($confirm) . \Static\Kernel::getSalt());

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE id = :id AND password = :confirm");
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!$query->fetch()) return "confirm";

            $query = parent::$pdo->prepare("UPDATE Users SET password = :password WHERE id = :id");
            $query->bindValue(":password", $password, PDO::PARAM_STR);
            $query->bindValue(":id", $id, PDO::PARAM_INT);

            return $query->execute() ? "success" : "error";
        }

        public static function isEmail($email) {
            $email = htmlspecialchars($email);

            $id = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($email)) return "empty";
            else if(!preg_match("#^[0-9A-Za-z-_.]{3,64}@[0-9A-Za-z-_.]{3,64}$#", $email)) return "invalid";

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE email = :email AND id != :id");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch() ? "used" : "success";
        }

        public static function isUsername($username) {
            $username = htmlspecialchars($username);

            $id = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($username)) return "empty";
            else if(!preg_match("#^[0-9A-Za-z]{3,16}$#", $username)) return "invalid";

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE username = :username AND id != :id");
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch() ? "used" : "success";
        }

        public static function isPassword($password) {
            $password = htmlspecialchars($password);

            if(empty($password)) return "empty";
            else if(!preg_match("#^[0-9A-Za-z-_.]{3,16}$#", $password)) return "invalid";

            return "success";
        }

        public static function createPassword() {
            $password = "";

            while(strlen($password) != 15) {
                $random = rand(0, 61);

                if(strlen($password) % 4 == 3) $password .= "-";
                else if($random < 10) $password .= $random;
                else if($random < 36) $password .= chr($random + 55);
                else $password .= chr($random + 61);
            }

            return $password;
        }

    }

?>