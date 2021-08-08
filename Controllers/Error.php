<?php

    namespace Static\Controllers;

    final class Error extends Main {

        public static function start($parameters) {
            $errors = array(201, 202, 301, 302, 307, 308, 400, 401, 403, 404, 500, 503);

            if(!array_key_exists("error", $parameters) || !in_array($parameters["error"], $errors) || !array_key_exists("text", $parameters)) {
                $parameters["error"] = 200;
                $parameters["text"] = "Unknown Error";
            }

            $parameters["title"] = \Static\Languages\Translate::getText("title-error") . " " . (int)$parameters["error"];

            return $parameters;
        }

    }

?>