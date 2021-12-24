<?php

    namespace Static\Controllers;

    final class Article extends Main {

        public static function start($parameters) {
            $article = \Static\Models\Articles::getArticle(\Static\Kernel::getValue($parameters, "link"));

            if(!$article) {
                header("Location: " . \Static\Kernel::getPath("/news"));

                exit();
            }

            $parameters["published"] = date_format(date_create(\Static\Kernel::getValue($article, "Published")), \Static\Kernel::getDateFormat());
            $parameters["title"] = \Static\Kernel::getValue($article, "Title");
            $parameters["overview"] = \Static\Kernel::getValue($article, "Overview");
            $parameters["content"] =  nl2br(\Static\Kernel::getValue($article, "Content"));
            $parameters["image"] =  \Static\Kernel::getPath("/Public/Images/Articles/" . (int)(\Static\Kernel::getValue($article, "ID") / 2 + .5) . ".jpeg");

            $parameters["random"] = \Static\Models\Articles::getRandomArticles(\Static\Kernel::getValue($parameters, "link"));
            $parameters["cleanArticle"] = "\Static\Controllers\Article::cleanArticle";

            return $parameters;
        }

        public static function cleanArticle($article) {
            return array(
                "title" => \Static\Kernel::getValue($article, "Title"),
                "overview" => \Static\Kernel::getValue($article, "Overview"),
                "link" => \Static\Kernel::getValue($article, "Link"),
                "button" => \Static\Kernel::getPath("/article/" . \Static\Kernel::getValue($article, "Link")),
                "image" => \Static\Kernel::getPath("/Public/Images/Articles/" . (int)(\Static\Kernel::getValue($article, "ID") / 2 + .5) . ".jpeg"),
            );
        }

    }

?>