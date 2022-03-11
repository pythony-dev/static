<?php

    namespace Static\Models;

    use PDO;

    final class Articles extends Database {

        public static function getArticles($page) {
            $page = (int)$page;

            if($page <= 0) return array();

            $query = parent::$pdo->prepare("SELECT ID, Title, Overview, Link FROM Articles WHERE Language = :language ORDER BY ID DESC LIMIT :page, 5");
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->bindValue(":page", $page * 5 - 5, PDO::PARAM_INT);
            $query->execute();

            $results = array();

            while($article = $query->fetch()) {
                array_push($results, array(
                    "image" => \Static\Kernel::getPath("/Public/Images/Articles/" . (int)(\Static\Kernel::getValue($article, "ID") / 2 + .5) . ".jpeg"),
                    "title" => \Static\Kernel::getValue($article, "Title"),
                    "overview" => \Static\Kernel::getValue($article, "Overview"),
                    "link" => \Static\Kernel::getValue($article, "Link"),
                    "button" => \Static\Kernel::getPath("/article/" . \Static\Kernel::getValue($article, "Link")),
                ));
            }

            return $results;
        }

        public static function count() {
            $query = parent::$pdo->prepare("SELECT COUNT(ID) AS Count FROM Articles WHERE Language = :language");
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            return $query->fetch()["Count"] ?? 0;
        }

        public static function getArticle($link) {
            $query = parent::$pdo->prepare("SELECT ID, Published, Title, Overview, Content FROM Articles WHERE Link = :link AND Language = :language");
            $query->bindValue(":link", htmlspecialchars($link), PDO::PARAM_STR);
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            return $query->fetch();
        }

        public static function getRandomArticles($link) {
            $query = parent::$pdo->prepare("SELECT ID, Title, Overview, Link FROM Articles WHERE Link != :link AND Language = :language ORDER BY RAND() LIMIT 3");
            $query->bindValue(":link", htmlspecialchars($link), PDO::PARAM_STR);
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            $results = array();

            while($article = $query->fetch()) {
                array_push($results, array(
                    "image" => \Static\Kernel::getPath("/Public/Images/Articles/" . (int)(\Static\Kernel::getValue($article, "ID") / 2 + .5) . ".jpeg"),
                    "title" => \Static\Kernel::getValue($article, "Title"),
                    "overview" => \Static\Kernel::getValue($article, "Overview"),
                    "link" => \Static\Kernel::getValue($article, "Link"),
                    "button" => \Static\Kernel::getPath("/article/" . \Static\Kernel::getValue($article, "Link")),
                ));
            }

            return $results;
        }

    }

?>