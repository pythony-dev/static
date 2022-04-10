<?php

    namespace Static\Controllers;

    final class News extends Main {

        public static function start($parameters) {
            $parameters["page"] = array_key_exists("page", $parameters) && (int)$parameters["page"] >= 1 ? (int)$parameters["page"] : 1;
            $parameters["limit"] = ceil(\Static\Models\Articles::count() / 5);

            $parameters["articles"] = \Static\Models\Articles::getArticles($parameters["page"]);

            return $parameters;
        }

    }

?>