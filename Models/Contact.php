<?php

    namespace Static\Models;

    use PDO;

    final class Contact extends Database {

        public static function create($email, $message) {
            $query = parent::$pdo->prepare("INSERT INTO Contact (Sended, UserID, Email, Message) VALUES (NOW(), :userID, :email, :message)");
            $query->bindValue(":userID", (int)\Static\Kernel::getValue($_SESSION, "userID"), PDO::PARAM_INT);
            $query->bindValue(":email", htmlspecialchars($email), PDO::PARAM_STR);
            $query->bindValue(":message", htmlspecialchars($message), PDO::PARAM_STR);

            return $query->execute() && \Static\Models\Emails::send(htmlspecialchars($email), \Static\Languages\Translate::getText("emails-contact-title"), \Static\Languages\Translate::getText("emails-contact-content"));
        }

    }

?>