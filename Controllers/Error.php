<?php

    namespace Static\Controllers;

    final class Error extends Main {

        public static $errors = array(200, 201, 202, 301, 302, 307, 308, 400, 401, 403, 404, 408, 418, 429, 500, 502, 503);

        public static function start($parameters) {
            if(!array_key_exists("error", $parameters) || !in_array($parameters["error"], self::$errors) || !array_key_exists("response", $parameters)) {
                $parameters["error"] = 500;
                $parameters["response"] = $parameters["getText"]("error-internal");
            }

            $parameters["title"] = \Static\Languages\Translate::getText("title-error") . " " . (int)$parameters["error"];

            return $parameters;
        }

    }

?>