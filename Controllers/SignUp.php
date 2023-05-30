<?php

    namespace Static\Controllers;

    final class SignUp extends Main {

        public static function start($parameters) {
            if($parameters["userID"] >= 1) {
                header("Location: " . \Static\Kernel::getPath("/settings"));

                exit();
            }

            \Static\Kernel::addScript("/Public/Scripts/SignUp.js");

            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "signUp-alert-submit-confirm", "signUp-alert-submit-email", "signUp-alert-submit-code", "signUp-alert-submit-username", "signUp-alert-submit-password", "signUp-alert-submit-success", "signUp-alert-submit-error",
                "signUp-alert-confirmations-email", "signUp-alert-confirmations-success", "signUp-alert-confirmations-error",
            ));

            return $parameters;
        }

    }

?>