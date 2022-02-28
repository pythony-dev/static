<?php

    namespace Static\Models;

    use PDO;

    final class Contact extends Database {

        public static function create($email, $message) {
            $email = htmlspecialchars($email);
            $message = htmlspecialchars($message);

            if(empty($email) || empty($message)) return "empty";

            $query = parent::$pdo->prepare("INSERT INTO Contact (Sended, SessionID, Email, Message) VALUES (NOW(), :sessionID, :email, :message)");
            $query->bindValue(":sessionID", (int)\Static\Kernel::getValue($_SESSION, "sessionID"), PDO::PARAM_INT);
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