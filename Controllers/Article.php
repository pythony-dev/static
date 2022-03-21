<?php

    namespace Static\Controllers;

    final class Article extends Main {

        public static function start($parameters) {
            $article = \Static\Models\Articles::getArticle(\Static\Kernel::getValue($parameters, "link"));

            if(!$article) {
                header("Location: " . \Static\Kernel::getPath("/news"));

                exit();
            }

            $parameters["image"] =  \Static\Kernel::getPath("/Public/Images/Articles/" . (int)(\Static\Kernel::getValue($article, "id") / 2 + .5) . ".jpeg");
            $parameters["published"] = date_format(date_create(\Static\Kernel::getValue($article, "published")), \Static\Kernel::getDateFormat());
            $parameters["title"] = \Static\Kernel::getValue($article, "title");
            $parameters["overview"] = \Static\Kernel::getValue($article, "overview");
            $parameters["content"] =  nl2br(\Static\Kernel::getValue($article, "content"));

            $parameters["random"] = \Static\Models\Articles::getRandomArticles(\Static\Kernel::getValue($parameters, "link"));

            return $parameters;
        }

    }

?>