<?php

    namespace Static\Controllers;

    final class News extends Main {

        public static function start($parameters) {
            $parameters["articles"] = \Static\Models\Articles::getArticles();
            $parameters["cleanArticle"] = "\Static\Controllers\Article::cleanArticle";

            return $parameters;
        }

    }

?>