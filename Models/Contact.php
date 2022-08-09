<?php

    namespace Static\Models;

    use PDO;

    final class Contact extends Database {

        public static function create($email, $message) {
            $email = htmlspecialchars($email);
            $message = htmlspecialchars($message);

            $sessionID = (int)\Static\Kernel::getValue($_SESSION, "sessionID");

            if(empty($email)) return "email";
            else if(empty($message)) return "message";
            else if($sessionID <= 0) return "error";

            $query = parent::$pdo->prepare("INSERT INTO Contact (created, sessionID, email, message) VALUES (NOW(), :sessionID, :email, :message)");
            $query->bindValue(":sessionID", $sessionID, PDO::PARAM_INT);
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