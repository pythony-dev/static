<?php

    namespace Static\Models;

    use PDO;

    final class Articles extends Database {

        public static function getArticles($page) {
            $page = (int)$page;

            if($page <= 0) return array();

            $query = parent::$pdo->prepare("SELECT id, title, overview, link FROM " . parent::getPrefix() . "Articles WHERE NOW() >= published AND language = :language ORDER BY id DESC LIMIT :page, 5");
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->bindValue(":page", $page * 5 - 5, PDO::PARAM_INT);
            $query->execute();

            $results = array();

            while($article = $query->fetch()) {
                array_push($results, array(
                    "image" => \Static\Kernel::getPath("/Public/Images/Articles/" . \Static\Kernel::getHash("Article", \Static\Kernel::getID(\Static\Kernel::getValue($article, "id"))) . ".jpeg"),
                    "title" => \Static\Kernel::getValue($article, "title"),
                    "overview" => \Static\Kernel::getValue($article, "overview"),
                    "link" => \Static\Kernel::getValue($article, "link"),
                ));
            }

            return $results;
        }

        public static function count() {
            $query = parent::$pdo->prepare("SELECT COUNT(id) AS count FROM " . parent::getPrefix() . "Articles WHERE NOW() >= published AND language = :language");
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            return max($query->fetch()["count"] ?? 0, 1);
        }

        public static function getArticle($link) {
            $link = htmlspecialchars($link);

            if(empty($link)) return array();

            $query = parent::$pdo->prepare("SELECT id, published, title, overview, content, networks FROM " . parent::getPrefix() . "Articles WHERE link = :link AND language = :language");
            $query->bindValue(":link", $link, PDO::PARAM_STR);
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            return $query->fetch();
        }

        public static function getRandomArticles($link) {
            $link = htmlspecialchars($link);

            $query = parent::$pdo->prepare("SELECT id, title, overview, link FROM " . parent::getPrefix() . "Articles WHERE NOW() >= published AND link != :link AND language = :language ORDER BY RAND() LIMIT 3");
            $query->bindValue(":link", $link, PDO::PARAM_STR);
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            $results = array();

            while($article = $query->fetch()) {
                array_push($results, array(
                    "image" => \Static\Kernel::getPath("/Public/Images/Articles/" . \Static\Kernel::getHash("Article", \Static\Kernel::getID(\Static\Kernel::getValue($article, "id"))) . ".jpeg"),
                    "title" => \Static\Kernel::getValue($article, "title"),
                    "overview" => \Static\Kernel::getValue($article, "overview"),
                    "link" => \Static\Kernel::getValue($article, "link"),
                ));
            }

            return $results;
        }

        public static function newsletter() {
            $users = \Static\Models\Users::getUsers();
            $languages = array();

            $query = parent::$pdo->query("SELECT title, overview, link, language FROM " . parent::getPrefix() . "Articles WHERE DATE(NOW()) = DATE(published)");

            while($article = $query->fetch()) {
                foreach($users as $user) {
                    if(\Static\Kernel::getValue($article, "language") == \Static\Kernel::getValue($user, "language") && \Static\Kernel::getValue($user, "published") == "true") {
                        \Static\Languages\Translate::setLanguage(\Static\Kernel::getValue($user, "language"));

                        $email = \Static\Kernel::getValue($user, "email");
                        $title = \Static\Languages\Translate::getText("emails-newsletter-title");
                        $content = \Static\Languages\Translate::getText("emails-newsletter-content", true, array(
                            "title" => \Static\Kernel::getValue($article, "title"),
                            "overview" => \Static\Kernel::getValue($article, "overview"),
                            "read" => \Static\Kernel::getPath("/article/" . \Static\Kernel::getValue($article, "link") . "?" . \Static\Emails::getParameters()),
                        ));

                        \Static\Emails::send($email, $title, $content);
                    }
                }

                if(!in_array(\Static\Kernel::getValue($article, "language"), $languages)) array_push($languages, \Static\Kernel::getValue($article, "language"));
            }

            if(date("w") == 6) {
                foreach(array_diff(\Static\Languages\Translate::getAllLanguages(), $languages) as $language) {
                    \Static\Languages\Translate::setLanguage($language);

                    foreach($users as $user) {
                        if(\Static\Kernel::getValue($user, "language") == $language && \Static\Kernel::getValue($user, "published") == "true") {
                            $articles = self::getRandomArticles("");

                            if(count($articles) >= 1) {
                                $email = \Static\Kernel::getValue($user, "email");
                                $title = \Static\Languages\Translate::getText("emails-newsletter-title");
                                $content = \Static\Languages\Translate::getText("emails-newsletter-content", true, array(
                                    "title" => \Static\Kernel::getValue($articles[0], "title"),
                                    "overview" => \Static\Kernel::getValue($articles[0], "overview"),
                                    "read" => \Static\Kernel::getPath("/article/" . \Static\Kernel::getValue($articles[0], "link") . "?" . \Static\Emails::getParameters()),
                                ));

                                \Static\Emails::send($email, $title, $content);
                            }
                        }
                    }
                }
            }

            return true;
        }

    }

?>