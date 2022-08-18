<?php

    namespace Static\Models;

    use PDO;

    final class Users extends Database {

        public static function signUp($email, $username, $agree) {
            $email = htmlspecialchars($email);
            $username = htmlspecialchars($username);
            $agree = htmlspecialchars($agree);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");
            $language = \Static\Languages\Translate::getLanguage();

            if(self::isEmail($email) != "success") return "email";
            else if(self::isUsername($username) != "success") return "username";
            else if($agree != "true") return "agree";
            else if($sessionID <= 0 || $userID != 0 || !in_array($language, \Static\Languages\Translate::getAllLanguages())) return "error";

            $password = self::createPassword();

            $query = parent::$pdo->prepare("INSERT INTO Users (created, deleted, sessionID, email, username, language, notifications, password, reset) VALUES (NOW(), NULL, :sessionID, :email, :username, :language, :notifications, :password, NULL)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":language", $language, PDO::PARAM_STR);
            $query->bindValue(":notifications", htmlspecialchars(json_encode([
                "published" => "true",
            ])), PDO::PARAM_STR);
            $query->bindValue(":password", sha1($password . \Static\Kernel::getSalt()), PDO::PARAM_STR);

            $title = \Static\Languages\Translate::getText("emails-signUp-title");
            $content = \Static\Languages\Translate::getText("emails-signUp-content", true, array(
                "log-in" => \Static\Kernel::getPath("/log-in"),
                "settings" => \Static\Kernel::getPath("/settings"),
                "user-email" => $email,
                "user-password" => $password,
            ));

            return $query->execute() && copy("Public/Images/Users/" . sha1(\Static\Kernel::getSalt() . "0") . ".jpeg", "Public/Images/Users/" . sha1(\Static\Kernel::getSalt() . parent::$pdo->lastInsertId()) . ".jpeg") && \Static\Emails::send($email, $title, $content) ? "success" : "error";
        }

        public static function logIn($email, $password) {
            $email = htmlspecialchars($email);
            $password = sha1(htmlspecialchars($password) . \Static\Kernel::getSalt());

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($email)) return "email";
            else if(empty($password)) return "password";
            else if($userID != 0) return "error";

            $query = parent::$pdo->prepare("SELECT id, language, password, reset FROM Users WHERE email = :email AND deleted IS NULL");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->execute();

            if(!($results = $query->fetch())) return "email";

            $userID = (int)$results["id"];

            if($userID < 1) return "email";
            else if($results["password"] == $password) {
                $_SESSION["userID"] = $userID;
                $_SESSION["language"] = htmlspecialchars($results["language"]);

                $query = parent::$pdo->prepare("UPDATE Users SET reset = NULL WHERE id = :userID AND deleted IS NULL");
                $query->bindValue(":userID", $userID, PDO::PARAM_INT);

                return \Static\Models\Logs::create($userID, "success") && $query->execute() ? "success" : "error";
            } else if($results["reset"] == $password) {
                $_SESSION["userID"] = $userID;
                $_SESSION["language"] = htmlspecialchars($results["language"]);

                $query = parent::$pdo->prepare("UPDATE Users SET password = reset, reset = NULL WHERE id = :userID AND deleted IS NULL");
                $query->bindValue(":userID", $userID, PDO::PARAM_INT);

                return \Static\Models\Logs::create($userID, "reset") && \Static\Models\Updates::create("reset", $results["password"]) && $query->execute() ? "success" : "error";
            } else {
                \Static\Models\Logs::create($userID, "error");

                return "password";
            }
        }

        public static function reset($email) {
            $email = htmlspecialchars($email);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($userID != 0) return "error";
            else if(self::isEmail($email) != "used") return "email";

            $reset = self::createPassword();

            $query = parent::$pdo->prepare("UPDATE Users SET reset = :reset WHERE email = :email AND deleted IS NULL");
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
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($userID < 1) return array();

            $query = parent::$pdo->prepare("SELECT id, email, username, language, notifications FROM Users WHERE id = :userID AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->execute();

            if($user = $query->fetch()) {
                $user["image"] = \Static\Kernel::getPath("/Public/Images/Users/" . sha1(\Static\Kernel::getSalt() . $user["id"]) . ".jpeg?" . time());

                return $user;
            } else return array();
        }

        public static function update($email, $username, $language, $confirm) {
            $email = htmlspecialchars($email);
            $username = htmlspecialchars($username);
            $language = htmlspecialchars($language);
            $confirm = sha1(htmlspecialchars($confirm) . \Static\Kernel::getSalt());

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($userID < 1) return "confirm";
            else if(self::isEmail($email) != "success") return "email";
            else if(self::isUsername($username) != "success") return "username";
            else if(!in_array($language, \Static\Languages\Translate::getAllLanguages())) return "error";

            $query = parent::$pdo->prepare("SELECT email, username FROM Users WHERE id = :userID AND password = :confirm AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!($results = $query->fetch())) return "confirm";

            $_SESSION["language"] = $language;

            $query = parent::$pdo->prepare("UPDATE Users SET email = :email, username = :username, language = :language WHERE id = :userID");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":language", $language, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            return \Static\Models\Updates::create("email", $results["email"]) && \Static\Models\Updates::create("username", $results["username"]) && $query->execute() ? "success" : "error";
        }

        public static function notify($notifications, $confirm) {
            $notifications = htmlspecialchars($notifications);
            $confirm = sha1(htmlspecialchars($confirm) . \Static\Kernel::getSalt());

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($userID < 1) return "confirm";
            else if(empty($notifications)) return "error";

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE id = :userID AND password = :confirm AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!$query->fetch()) return "confirm";

            $query = parent::$pdo->prepare("UPDATE Users SET notifications = :notifications WHERE id = :userID");
            $query->bindValue(":notifications", $notifications, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            return $query->execute() ? "success" : "error";
        }

        public static function change($password, $confirm) {
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($userID < 1) return "confirm";
            else if(self::isPassword($password) != "success") return "password";

            $password = sha1(htmlspecialchars($password) . \Static\Kernel::getSalt());
            $confirm = sha1(htmlspecialchars($confirm) . \Static\Kernel::getSalt());

            $query = parent::$pdo->prepare("SELECT password FROM Users WHERE id = :userID AND password = :confirm AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!($results = $query->fetch())) return "confirm";

            $query = parent::$pdo->prepare("UPDATE Users SET password = :password, reset = NULL WHERE id = :userID");
            $query->bindValue(":password", $password, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            return \Static\Models\Updates::create("password", $results["password"]) && $query->execute() ? "success" : "error";
        }

        public static function delete($confirm) {
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if($userID < 1) return "confirm";

            $confirm = sha1(htmlspecialchars($confirm) . \Static\Kernel::getSalt());

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE id = :userID AND password = :confirm AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!$query->fetch()) return "confirm";

            $query = parent::$pdo->prepare("UPDATE Users SET deleted = NOW() WHERE id = :userID");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            if($query->execute() && (int)$query->rowCount() >= 1) {
                $_SESSION["userID"] = 0;

                return "success";
            } else return "error";
        }

        public static function isEmail($email) {
            $email = htmlspecialchars($email);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($email)) return "empty";
            else if(!preg_match("#^[0-9A-Za-z-_.]{3,64}@[0-9A-Za-z-_.]{3,64}$#", $email)) return "invalid";

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE email = :email AND id != :userID AND deleted IS NULL");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch() ? "used" : "success";
        }

        public static function isUsername($username) {
            $username = htmlspecialchars($username);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($username)) return "empty";
            else if(!preg_match("#^[0-9A-Za-z]{3,16}$#", $username)) return "invalid";

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE username = :username AND id != :userID AND deleted IS NULL");
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch() ? "used" : "success";
        }

        public static function isPassword($password) {
            $password = htmlspecialchars($password);

            if(empty($password)) return "empty";
            else if(!preg_match("#^[0-9A-Za-z-_.]{3,16}$#", $password)) return "invalid";
            else return "success";
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