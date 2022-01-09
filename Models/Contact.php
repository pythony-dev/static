<?php

    namespace Static\Models;

    use PDO;

    final class Contact extends Database {

        public static function create($email, $message) {
            if(empty($email) || empty($message)) return false;

            $query = parent::$pdo->prepare("INSERT INTO Contact (Sended, SessionID, Email, Message) VALUES (NOW(), :sessionID, :email, :message)");
            $query->bindValue(":sessionID", (int)\Static\Kernel::getValue($_SESSION, "sessionID"), PDO::PARAM_INT);
            $query->bindValue(":email", htmlspecialchars($email), PDO::PARAM_STR);
            $query->bindValue(":message", htmlspecialchars($message), PDO::PARAM_STR);

            return $query->execute() && \Static\Models\Emails::send(htmlspecialchars($email), \Static\Languages\Translate::getText("emails-contact-title"), \Static\Languages\Translate::getText("emails-contact-content"));
        }

    }

?>