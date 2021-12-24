<?php

    namespace Static\Controllers;

    final class News extends Main {

        public static function start($parameters) {
            $parameters["page"] = (int)($parameters["page"] ?? 1);
            $parameters["limit"] = ceil(\Static\Models\Articles::count() / 5);

            if($parameters["page"] < 1 || $parameters["page"] > $parameters["limit"]) {
                header("Location: " . \Static\Kernel::getPath("/news"));

                exit();
            }

            $parameters["articles"] = \Static\Models\Articles::getArticles($parameters["page"]);
            $parameters["cleanArticle"] = "\Static\Controllers\Article::cleanArticle";

            return $parameters;
        }

    }

?>