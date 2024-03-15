<?php

    namespace Static\Controllers;

    final class Welcome extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript("/Public/Scripts/Welcome.js");

            $parameters["alerts"] = array_merge($parameters["alerts"], array("welcome-alert-email", "welcome-alert-success", "welcome-alert-error"));

            return $parameters;
        }

    }

?>