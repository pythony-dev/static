<?php

    namespace Static\Models;

    use PDO;

    final class Users extends Database {

        public static function signUp($email, $username) {
            $email = htmlspecialchars($email);
            $username = htmlspecialchars($username);

            if(self::isEmail($email) != "success" || self::isUsername($username) != "success") return false;

            $password = self::createPassword();

            $query = parent::$pdo->prepare("INSERT INTO Users (Signed, Email, Username, Password, Reset) VALUES (NOW(), :email, :username, :password, NULL)");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":password", sha1($password . \Static\Kernel::getSalt()), PDO::PARAM_STR);

            return $query->execute() && copy("Public/Images/Users/0.png", "Public/Images/Users/" . parent::$pdo->lastInsertId() . ".png") && \Static\Emails::signUp($email, $password);
        }

        public static function logIn($email, $password) {
            $email = htmlspecialchars($email);
            $password = sha1(htmlspecialchars($password) . \Static\Kernel::getSalt());

            if(empty($email) || empty($password)) return false;

            $query = parent::$pdo->prepare("SELECT ID, Password, Reset FROM Users WHERE Email = :email");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->execute();

            if(!($results = $query->fetch())) return false;

            $id = (int)$results["ID"];

            if($results["Password"] == $password) {
                $_SESSION["userID"] = $id;

                $query = parent::$pdo->prepare("UPDATE Users SET Reset = NULL WHERE ID = :id");
                $query->bindValue(":id", $id, PDO::PARAM_INT);

                return $query->execute();
            } else if($results["Reset"] == $password) {
                $_SESSION["userID"] = $id;

                $query = parent::$pdo->prepare("UPDATE Users SET Password = Reset, Reset = NULL WHERE ID = :id");
                $query->bindValue(":id", $id, PDO::PARAM_INT);

                return $query->execute();
            } else return false;
        }

        public static function reset($email) {
            $email = htmlspecialchars($email);

            if(self::isEmail($email) != "used") return false;

            $reset = self::createPassword();

            $query = parent::$pdo->prepare("UPDATE Users SET Reset = :reset WHERE Email = :email");
            $query->bindValue(":reset", sha1($reset . \Static\Kernel::getSalt()), PDO::PARAM_STR);
            $query->bindValue(":email", $email, PDO::PARAM_STR);

            return $query->execute() && \Static\Emails::reset($email, $reset);
        }

        public static function getUser() {
            $id = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($id < 1) return array();

            $query = parent::$pdo->prepare("SELECT ID, Email, Username FROM Users WHERE ID = :id");
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
            else if(self::isEmail($email) != "success" || self::isUsername($username) != "success") return "invalid";

            $query = parent::$pdo->prepare("SELECT ID FROM Users WHERE ID = :id AND Password = :confirm");
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!$query->fetch()) return "password";

            $query = parent::$pdo->prepare("UPDATE Users SET Email = :email, Username = :username WHERE ID = :id");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":id", $id, PDO::PARAM_INT);

            return $query->execute() ? "success" : "error";
        }

        public static function change($password, $confirm) {
            $id = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($id < 1) return "user";
            else if(self::isPassword($password) != "success") return "invalid";

            $password = sha1(htmlspecialchars($password) . \Static\Kernel::getSalt());
            $confirm = sha1(htmlspecialchars($confirm) . \Static\Kernel::getSalt());

            $query = parent::$pdo->prepare("SELECT ID FROM Users WHERE ID = :id AND Password = :confirm");
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!$query->fetch()) return "password";

            $query = parent::$pdo->prepare("UPDATE Users SET Password = :password WHERE ID = :id");
            $query->bindValue(":password", $password, PDO::PARAM_STR);
            $query->bindValue(":id", $id, PDO::PARAM_INT);

            return $query->execute() ? "success" : "error";
        }

        public static function isEmail($email) {
            $email = htmlspecialchars($email);

            $id = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($email)) return "empty";
            else if(!preg_match("#^[0-9A-Za-z-_.]{3,64}@[0-9A-Za-z-_.]{3,64}$#", $email)) return "invalid";

            $query = parent::$pdo->prepare("SELECT ID FROM Users WHERE ID != :id AND Email = :email");
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->execute();

            return $query->fetch() ? "used" : "success";
        }

        public static function isUsername($username) {
            $username = htmlspecialchars($username);

            $id = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($username)) return "empty";
            else if(!preg_match("#^[0-9A-Za-z]{3,16}$#", $username)) return "invalid";

            $query = parent::$pdo->prepare("SELECT ID FROM Users WHERE ID != :id AND Username = :username");
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->execute();

            return $query->fetch() ? "used" : "success";
        }

        public static function isPassword($password) {
            $password = htmlspecialchars($password);

            if(empty($password)) return "empty";
            else if(!preg_match("#^[0-9A-Za-z]{3,16}$#", $password)) return "invalid";

            return "success";
        }

        public static function createPassword() {
            $password = "";

            while(strlen($password) != 16) {
                $random = rand(0, 61);

                if($random < 10) $password .= $random;
                else if($random < 36) $password .= chr($random + 55);
                else $password .= chr($random + 61);
            }

            return $password;
        }

    }

?>