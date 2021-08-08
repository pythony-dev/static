<?php

    namespace Static\Models;

    use PDO;

    final class Views extends Database {

        public static function create($link, $referer) {
            $query = parent::$pdo->prepare("INSERT INTO Views (Viewed, UserID, Language, Link, Referer) VALUES (NOW(), :userID, :language, :link, :referer)");
            $query->bindValue(":userID", (int)\Static\Kernel::getValue($_SESSION, "userID"), PDO::PARAM_INT);
            $query->bindValue(":language", \Static\Kernel::getValue($_SESSION, "language"), PDO::PARAM_STR);
            $query->bindValue(":link", htmlspecialchars($link), PDO::PARAM_STR);
            $query->bindValue(":referer", htmlspecialchars($referer), PDO::PARAM_STR);
            $query->execute();
        }

    }

?>