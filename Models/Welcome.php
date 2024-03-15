<?php

    namespace Static\Models;

    use PDO;

    final class Welcome extends Database {

        public static function create($email) {
            $email = htmlspecialchars($email);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(\Static\Models\Users::isEmail($email) != "success") return "email";
            else if($sessionID <= 0 || $userID < 0 || !self::delete($email)) return "error";

            $query = parent::$pdo->prepare("INSERT INTO Welcome (created, deleted, sessionID, userID, email, language) VALUES (NOW(), NULL, :sessionID, :userID, :email, :language)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);

            if(!$query->execute()) return "error";

            $title = \Static\Languages\Translate::getText("emails-welcome-title");
            $content = \Static\Languages\Translate::getText("emails-welcome-content", true, array(
                "sign-up" => \Static\Kernel::getPath("/sign-up?welcome=" . \Static\Kernel::getHash("Welcome", parent::$pdo->lastInsertId())),
            ));

            return \Static\Emails::send($email, $title, $content) ? "success" : "error";
        }

        public static function delete($email) {
            $email = htmlspecialchars($email);

            if(!in_array(\Static\Models\Users::isEmail($email), array("success", "used"))) return false;

            $query = parent::$pdo->prepare("UPDATE Welcome SET deleted = NOW() WHERE deleted IS NULL AND email = :email");
            $query->bindValue(":email", $email, PDO::PARAM_STR);

            return $query->execute();
        }

    }

?>