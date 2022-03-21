<?php

    namespace Static\Models;

    use PDO;

    final class Views extends Database {

        public static function create($link, $referer) {
            $query = parent::$pdo->prepare("INSERT INTO Views (created, sessionID, language, link, referer) VALUES (NOW(), :sessionID, :language, :link, :referer)");
            $query->bindValue(":sessionID", (int)\Static\Kernel::getValue($_SESSION, "sessionID"), PDO::PARAM_INT);
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->bindValue(":link", htmlspecialchars($link), PDO::PARAM_STR);
            $query->bindValue(":referer", htmlspecialchars($referer), PDO::PARAM_STR);
            $query->execute();
        }

    }

?>