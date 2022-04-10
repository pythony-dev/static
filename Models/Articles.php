<?php

    namespace Static\Models;

    use PDO;

    final class Articles extends Database {

        public static function getArticles($page) {
            $page = (int)$page;

            if($page < 1) return array();

            $query = parent::$pdo->prepare("SELECT id, title, overview, link FROM Articles WHERE language = :language ORDER BY id DESC LIMIT :page, 5");
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->bindValue(":page", $page * 5 - 5, PDO::PARAM_INT);
            $query->execute();

            $results = array();

            while($article = $query->fetch()) {
                array_push($results, array(
                    "image" => \Static\Kernel::getPath("/Public/Images/Articles/" . (int)(\Static\Kernel::getValue($article, "id") / 2 + .5) . ".jpeg"),
                    "title" => \Static\Kernel::getValue($article, "title"),
                    "overview" => \Static\Kernel::getValue($article, "overview"),
                    "button" => \Static\Kernel::getPath("/article/" . \Static\Kernel::getValue($article, "link")),
                ));
            }

            return $results;
        }

        public static function count() {
            $query = parent::$pdo->prepare("SELECT COUNT(id) AS count FROM Articles WHERE language = :language");
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            return $query->fetch()["count"] ?? 0;
        }

        public static function getArticle($link) {
            $query = parent::$pdo->prepare("SELECT id, published, title, overview, content FROM Articles WHERE link = :link AND language = :language");
            $query->bindValue(":link", htmlspecialchars($link), PDO::PARAM_STR);
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            return $query->fetch();
        }

        public static function getRandomArticles($link) {
            $query = parent::$pdo->prepare("SELECT id, title, overview, link FROM Articles WHERE link != :link AND language = :language ORDER BY RAND() LIMIT 3");
            $query->bindValue(":link", htmlspecialchars($link), PDO::PARAM_STR);
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            $results = array();

            while($article = $query->fetch()) {
                array_push($results, array(
                    "image" => \Static\Kernel::getPath("/Public/Images/Articles/" . (int)(\Static\Kernel::getValue($article, "id") / 2 + .5) . ".jpeg"),
                    "title" => \Static\Kernel::getValue($article, "title"),
                    "overview" => \Static\Kernel::getValue($article, "overview"),
                    "button" => \Static\Kernel::getPath("/article/" . \Static\Kernel::getValue($article, "link")),
                ));
            }

            return $results;
        }

    }

?>