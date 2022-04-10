<?php

    namespace Static\Controllers;

    final class Error extends Main {

        public static function start($parameters) {
            $errors = array(200, 201, 202, 301, 302, 307, 308, 400, 401, 403, 404, 408, 429, 500, 503);

            if(!array_key_exists("error", $parameters) || !in_array($parameters["error"], $errors) || !array_key_exists("message", $parameters)) {
                $parameters["error"] = 500;
                $parameters["message"] = "Internal Server Error";
            }

            $parameters["title"] = \Static\Languages\Translate::getText("title-error") . " " . (int)$parameters["error"];

            return $parameters;
        }

    }

?>