<?php

    namespace Static\Models;

    use PDO;

    final class Contact extends Database {

        public static function create($email, $message) {
            $email = htmlspecialchars($email);
            $message = htmlspecialchars($message);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");
            $userID = (int)\Static\Kernel::getValue($_SESSION, "userID");

            if(!in_array(\Static\Models\Users::isEmail($email), array("success", "used"))) return "email";
            else if(empty($message) || $sessionID <= 0 || $userID < 0) return "error";

            $query = parent::$pdo->prepare("INSERT INTO " . parent::getPrefix() . "Contact (created, sessionID, userID, email, message) VALUES (NOW(), :sessionID, :userID, :email, :message)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
            $query->bindValue(":userID", $userID, PDO::PARAM_INT);
            $query->bindValue(":email", $email, PDO::PARAM_STR);
            $query->bindValue(":message", $message, PDO::PARAM_STR);

            $title = \Static\Languages\Translate::getText("emails-contact-title");
            $content = \Static\Languages\Translate::getText("emails-contact-content", true, array(
                "message" => $message,
            ));

            return $query->execute() && \Static\Emails::send($email, $title, $content, true) ? "success" : "error";
        }

    }

?>