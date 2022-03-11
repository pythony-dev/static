<?php

    namespace Static\Controllers;

    final class LogIn extends Main {

        public static function start($parameters) {
            if($parameters["userID"] >= 1) {
                header("Location: " . \Static\Kernel::getPath("/settings"));

                exit();
            }

            \Static\Kernel::addScript(\Static\Kernel::getPath("/Public/Scripts/LogIn.js"));

            $parameters["alerts"] = array_merge($parameters["alerts"], array("logIn-alert-empty", "logIn-alert-notFound", "logIn-alert-password", "logIn-alert-error", "logIn-alert-reset-email", "logIn-alert-reset-success", "logIn-alert-reset-error"));

            return $parameters;
        }

    }

?>