<?php

    namespace Static\Controllers;

    final class LogIn extends Main {

        public static function start($parameters) {
            if($parameters["userID"] >= 1) {
                header("Location: " . \Static\Kernel::getPath("/settings"));

                exit();
            }

            \Static\Kernel::addScript("/Public/Scripts/LogIn.js");
            \Static\Kernel::addScript("/Public/Scripts/Reset.js");

            $parameters["modals"] = array_merge($parameters["modals"], array("reset"));
            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "logIn-alert-email", "logIn-alert-password", "logIn-alert-error",
                "reset-alert-submit-confirm", "reset-alert-submit-email", "reset-alert-submit-code", "reset-alert-submit-password", "reset-alert-submit-success", "reset-alert-submit-error",
                "reset-alert-confirmations-email", "reset-alert-confirmations-success", "reset-alert-confirmations-error",
            ));

            return $parameters;
        }

    }

?>