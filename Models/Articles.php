<?php

    namespace Static\Models;

    use PDO;

    final class Articles extends Database {

        public static function getArticles($page) {
            $page = (int)$page;

            if($page <= 0) return array();

            $query = parent::$pdo->prepare("SELECT ID, Title, Overview, Link FROM Articles WHERE Language = :language ORDER BY ID DESC LIMIT :page, 5");
            $query->bindValue(":language", htmlspecialchars(\Static\Languages\Translate::getLanguage()), PDO::PARAM_STR);
            $query->bindValue(":page", $page * 5 - 5, PDO::PARAM_INT);
            $query->execute();

            return $query->fetchAll();
        }

        public static function count() {
            $query = parent::$pdo->prepare("SELECT COUNT(ID) AS Count FROM Articles WHERE Language = :language");
            $query->bindValue(":language", htmlspecialchars(\Static\Languages\Translate::getLanguage()), PDO::PARAM_STR);
            $query->execute();

            return $query->fetch()["Count"] ?? 0;
        }

        public static function getArticle($link) {
            $query = parent::$pdo->prepare("SELECT ID, Published, Title, Overview, Content FROM Articles WHERE Link = :link AND Language = :language");
            $query->bindValue(":link", htmlspecialchars($link), PDO::PARAM_STR);
            $query->bindValue(":language", htmlspecialchars(\Static\Languages\Translate::getLanguage()), PDO::PARAM_STR);
            $query->execute();

            return $query->fetch();
        }

        public static function getRandomArticles($link) {
            $query = parent::$pdo->prepare("SELECT ID, Title, Overview, Link FROM Articles WHERE Link != :link AND Language = :language ORDER BY RAND() LIMIT 3");
            $query->bindValue(":link", htmlspecialchars($link), PDO::PARAM_STR);
            $query->bindValue(":language", htmlspecialchars(\Static\Languages\Translate::getLanguage()), PDO::PARAM_STR);
            $query->execute();

            return $query->fetchAll();
        }

    }

?>