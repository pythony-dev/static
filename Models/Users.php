<?php

    namespace Static\Models;

    use PDO;

    final class Users extends Database {

        public static function signUp($email, $code, $username, $password, $agree) {
            $email = htmlspecialchars($email);
            $code = htmlspecialchars($code);
            $username = htmlspecialchars($username);
            $password = htmlspecialchars($password);
            $agree = htmlspecialchars($agree);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");
            $language = \Static\Languages\Translate::getLanguage();
            $theme = \Static\Kernel::getValue($_SESSION, array("theme", "color"));

            if(self::isEmail($email) != "success") return "email";
            else if(!\Static\Models\Confirmations::check($email, $code)) return "code";
            else if(self::isUsername($username) != "success") return "username";
            else if(self::isPassword($password) != "success") return "password";
            else if($agree != "true" || $sessionID <= 0 || $userID != 0 || !in_array($language, \Static\Languages\Translate::getAllLanguages())) return "error";

            $query = parent::$pdo->prepare("INSERT INTO Users (created, deleted, sessionID, email, username, language, notifications, others, password) VALUES (NOW(), NULL, :sessionID, :email, :username, :language, :notifications, :others, :password)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":language", $language, PDO::PARAM_STR);
            $query->bindValue(":notifications", htmlspecialchars(json_encode(array(
                "message" => "true",
                "published" => "true",
            ))), PDO::PARAM_STR);
            $query->bindValue(":others", htmlspecialchars(json_encode(array(
                "theme" => array_key_exists($theme, \Static\Kernel::getThemes()) ? $theme : "aqua",
                "languages" => implode(",", \Static\Languages\Translate::getAllLanguages()),
                "contact" => "true",
            ))), PDO::PARAM_STR);
            $query->bindValue(":password", \Static\Kernel::getHash("Password", $password), PDO::PARAM_STR);

            $title = \Static\Languages\Translate::getText("emails-signUp-title");
            $content = \Static\Languages\Translate::getText("emails-signUp-content", true, array(
                "log-in" => \Static\Kernel::getPath("/log-in"),
                "settings" => \Static\Kernel::getPath("/settings"),
            ));

            return \Static\Models\Confirmations::delete($email) && $query->execute() && copy("Public/Images/Users/" . \Static\Kernel::getHash("User", 0) . ".jpeg", "Public/Images/Users/" . \Static\Kernel::getHash("User", parent::$pdo->lastInsertId()) . ".jpeg") && \Static\Emails::send($email, $title, $content) && \Static\Models\Welcome::delete($email) ? array(
                "status" => "success",
                "link" => \Static\Kernel::getPath("/log-in"),
            ) : "error";
        }

        public static function logIn($email, $password) {
            $email = htmlspecialchars($email);
            $password = htmlspecialchars($password);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($email) || empty($password) || $userID != 0) return "error";

            $password = \Static\Kernel::getHash("Password", $password);

            $query = parent::$pdo->prepare("SELECT id, language, others, password FROM Users WHERE email = :email AND deleted IS NULL");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->execute();

            if(!($results = $query->fetch())) return "email";

            $userID = (int)$results["id"];

            if($userID <= 0) return "email";
            else if($results["password"] == $password) {
                $_SESSION["userID"] = $userID;

                $language = $results["language"];

                if(in_array($language, \Static\Languages\Translate::getAllLanguages())) $_SESSION["language"] = $language;

                $color = \Static\Kernel::getValue(json_decode(htmlspecialchars_decode(htmlspecialchars_decode($results["others"])), true), "theme");

                if(in_array($color, array_keys(\Static\Kernel::getThemes()))) $_SESSION["theme"] = array(
                    "color" => $color,
                    "mode" => \Static\Kernel::getValue($_SESSION, array("theme", "mode")),
                );

                return \Static\Models\Logs::create($userID, "success") ? array(
                    "status" => "success",
                    "link" => \Static\Kernel::getPath("/settings"),
                ) : "error";
            } else return \Static\Models\Logs::create($userID, "error") ? "password" : "error";
        }

        public static function reset($email, $code, $password) {
            $email = htmlspecialchars($email);
            $code = htmlspecialchars($code);
            $password = htmlspecialchars($password);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(self::isEmail($email) != "used") return "email";
            else if(!\Static\Models\Confirmations::check($email, $code)) return "code";
            else if(self::isPassword($password) != "success") return "password";
            else if($userID != 0) return "error";

            $query = parent::$pdo->prepare("SELECT id, password FROM Users WHERE email = :email AND deleted IS NULL");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->execute();

            if(!($results = $query->fetch())) return "error";

            $query = parent::$pdo->prepare("UPDATE Users SET password = :password WHERE email = :email AND deleted IS NULL");
            $query->bindValue(":password", \Static\Kernel::getHash("Password", $password), PDO::PARAM_STR);
            $query->bindValue(":email", $email, PDO::PARAM_STR);

            $title = \Static\Languages\Translate::getText("emails-reset-title");
            $content = \Static\Languages\Translate::getText("emails-reset-content", true, array(
                "log-in" => \Static\Kernel::getPath("/log-in"),
                "settings" => \Static\Kernel::getPath("/settings"),
            ));

            return \Static\Models\Confirmations::delete($email) && $query->execute() && \Static\Models\Updates::create("reset", $results["password"], $results["id"]) && \Static\Emails::send($email, $title, $content) ? "success" : "error";
        }

        public static function search($search) {
            $search = htmlspecialchars($search);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($search) || $userID <= 0) return "error";

            $query = parent::$pdo->prepare("SELECT id, username FROM Users WHERE id != :userID AND deleted IS NULL AND username LIKE :username ORDER BY ID DESC LIMIT 10");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":username", $search . "%", PDO::PARAM_STR);
            $query->execute();

            $results = array();

            while($user = $query->fetch()) {
                $hash = \Static\Kernel::getHash("User", \Static\Kernel::getValue($user, "id"));

                array_push($results, array(
                    "image" => \Static\Kernel::getPath("/Public/Images/Users/" . $hash . ".jpeg?" . time()),
                    "username" => \Static\Kernel::getValue($user, "username"),
                    "hash" => $hash,
                    "chat" => \Static\Models\Messages::isContact(\Static\Kernel::getValue($user, "id")) == "success" ? \Static\Kernel::getPath("/chat/" . $hash) : null,
                ));
            }

            return array(
                "status" => "success",
                "users" => $results,
            );
        }

        public static function getUser($userID) {
            $userID = (int)$userID;

            if($userID <= 0) return array();

            $query = parent::$pdo->prepare("SELECT id, email, username, language, notifications, others FROM Users WHERE id = :userID AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->execute();

            if($user = $query->fetch()) {
                $user["image"] = \Static\Kernel::getPath("/Public/Images/Users/" . \Static\Kernel::getHash("User", $user["id"]) . ".jpeg?" . time());

                return $user;
            } else return array();
        }

        public static function getUsers() {
            $query = parent::$pdo->query("SELECT email, language, notifications FROM Users WHERE deleted IS NULL");

            $results = array();

            while($user = $query->fetch()) {
                array_push($results, array(
                    "email" => \Static\Kernel::getValue($user, "email"),
                    "language" => \Static\Kernel::getValue($user, "language"),
                    "published" => \Static\Kernel::getValue(json_decode(htmlspecialchars_decode(htmlspecialchars_decode(\Static\Kernel::getValue($user, "notifications"))), true), "published"),
                ));
            }

            return $results;
        }

        public static function update($email, $username, $language, $confirm) {
            $email = htmlspecialchars($email);
            $username = htmlspecialchars($username);
            $language = htmlspecialchars($language);
            $confirm = htmlspecialchars($confirm);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(self::isEmail($email) != "success") return "email";
            else if(self::isUsername($username) != "success") return "username";
            else if(!in_array($language, \Static\Languages\Translate::getAllLanguages()) || empty($confirm) || $userID <= 0) return "error";

            $confirm = \Static\Kernel::getHash("Password", $confirm);

            $query = parent::$pdo->prepare("SELECT email, username FROM Users WHERE id = :userID AND password = :confirm AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!($results = $query->fetch())) return "confirm";

            if(in_array($language, \Static\Languages\Translate::getAllLanguages())) $_SESSION["language"] = $language;

            $query = parent::$pdo->prepare("UPDATE Users SET email = :email, username = :username, language = :language WHERE id = :userID");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":language", $language, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            return \Static\Models\Updates::create("email", $results["email"]) && \Static\Models\Updates::create("username", $results["username"]) && $query->execute() ? array(
                "status" => "success",
                "link" => \Static\Kernel::getPath("/settings"),
            ) : "error";
        }

        public static function notifications($notifications, $confirm) {
            $notifications = htmlspecialchars($notifications);
            $confirm = htmlspecialchars($confirm);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($notifications) || empty($confirm) || $userID <= 0) return "error";

            $confirm = \Static\Kernel::getHash("Password", $confirm);

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE id = :userID AND password = :confirm AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!$query->fetch()) return "confirm";

            $query = parent::$pdo->prepare("UPDATE Users SET notifications = :notifications WHERE id = :userID");
            $query->bindValue(":notifications", $notifications, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            return $query->execute() ? array(
                "status" => "success",
                "link" => \Static\Kernel::getPath("/settings?notifications"),
            ) : "error";
        }

        public static function others($others, $confirm) {
            $others = htmlspecialchars($others);
            $confirm = htmlspecialchars($confirm);

            $languages = \Static\Kernel::getValue(json_decode(htmlspecialchars_decode($others), true), "languages");
            $found = false;

            foreach(\Static\Languages\Translate::getAllLanguages() as $language) if(str_contains($languages, $language)) $found = true;

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(!$found) return "languages";
            else if(empty($others) || empty($confirm) || $userID <= 0) return "error";

            $confirm = \Static\Kernel::getHash("Password", $confirm);

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE id = :userID AND password = :confirm AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!$query->fetch()) return "confirm";

            $query = parent::$pdo->prepare("UPDATE Users SET others = :others WHERE id = :userID");
            $query->bindValue(":others", $others, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            $color = \Static\Kernel::getValue(json_decode(htmlspecialchars_decode(htmlspecialchars_decode($others)), true), "theme");

            if(in_array($color, array_keys(\Static\Kernel::getThemes()))) $_SESSION["theme"] = array(
                "color" => $color,
                "mode" => \Static\Kernel::getValue($_SESSION, array("theme", "mode")),
            );

            return $query->execute() ? array(
                "status" => "success",
                "link" => \Static\Kernel::getPath("/settings?others"),
            ) : "error";
        }

        public static function change($password, $confirm) {
            $password = htmlspecialchars($password);
            $confirm = htmlspecialchars($confirm);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(self::isPassword($password) != "success") return "password";
            else if(self::isPassword($confirm) != "success") return "confirm";
            else if($userID <= 0) return "error";

            $password = \Static\Kernel::getHash("Password", $password);
            $confirm = \Static\Kernel::getHash("Password", $confirm);

            $query = parent::$pdo->prepare("SELECT password FROM Users WHERE id = :userID AND password = :confirm AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!($results = $query->fetch())) return "confirm";

            $query = parent::$pdo->prepare("UPDATE Users SET password = :password WHERE id = :userID");
            $query->bindValue(":password", $password, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            return \Static\Models\Updates::create("password", $results["password"]) && $query->execute() ? array(
                "status" => "success",
                "link" => \Static\Kernel::getPath("/settings"),
            ) : "error";
        }

        public static function delete($confirm) {
            $confirm = htmlspecialchars($confirm);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(self::isPassword($confirm) != "success") return "confirm";
            else if($userID <= 0) return "error";

            $confirm = \Static\Kernel::getHash("Password", $confirm);

            $query = parent::$pdo->prepare("SELECT email FROM Users WHERE id = :userID AND password = :confirm AND deleted IS NULL");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":confirm", $confirm, PDO::PARAM_STR);
            $query->execute();

            if(!($email = \Static\Kernel::getValue($query->fetch(), "email"))) return "confirm";
            else if(!\Static\Models\Messages::deleteUser()) return "error";

            $query = parent::$pdo->prepare("UPDATE Users SET deleted = NOW() WHERE id = :userID");
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);

            if($query->execute() && (int)$query->rowCount() == 1) {
                $_SESSION["userID"] = 0;

                $title = \Static\Languages\Translate::getText("emails-delete-title");
                $content = \Static\Languages\Translate::getText("emails-delete-content", true, array(
                    "sign-up" => \Static\Kernel::getPath("/sign-up"),
                ));

                return \Static\Emails::send($email, $title, $content) ? array(
                    "status" => "success",
                    "link" => \Static\Kernel::getPath("/sign-up"),
                ) : "error";
            } else return "error";
        }

        public static function getID($hash) {
            $hash = htmlspecialchars($hash);

            if(empty($hash)) return 0;

            $query = parent::$pdo->query("SELECT id FROM Users WHERE deleted IS NULL ORDER BY ID DESC");

            while($response = $query->fetch()) {
                if(\Static\Kernel::getHash("User", $response["id"]) == $hash) return $response["id"];
            }

            return 0;
        }

        public static function isEmail($email) {
            $email = htmlspecialchars($email);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($email) || !preg_match("#^[0-9A-Za-z-_.]{3,64}@[0-9A-Za-z-_.]{3,64}$#", $email)) return "invalid";
            else if($userID < 0) return "error";

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE email = :email AND id != :userID AND deleted IS NULL");
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch() ? "used" : "success";
        }

        public static function isUsername($username) {
            $username = htmlspecialchars($username);

            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(empty($username) || !preg_match("#^[0-9A-Za-z]{3,16}$#", $username)) return "invalid";
            else if($userID < 0) return "error";

            $query = parent::$pdo->prepare("SELECT id FROM Users WHERE username = :username AND id != :userID AND deleted IS NULL");
            $query->bindValue(":username", $username, PDO::PARAM_STR);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->execute();

            return $query->fetch() ? "used" : "success";
        }

        public static function isPassword($password) {
            $password = htmlspecialchars($password);

            foreach(str_split($password) as $character) if(ord($character) < 32 || ord($character) > 126) return "invalid";

            return !empty($password) && strlen($password) >= 3 && strlen($password) <= 16 ? "success" : "invalid";
        }

    }

?>