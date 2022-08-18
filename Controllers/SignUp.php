<?php

    namespace Static\Controllers;

    final class SignUp extends Main {

        public static function start($parameters) {
            if($parameters["userID"] >= 1) {
                header("Location: " . \Static\Kernel::getPath("/settings"));

                exit();
            }

            \Static\Kernel::addScript("/Public/Scripts/SignUp.js");

            $parameters["alerts"] = array_merge($parameters["alerts"], array("signUp-alert-email", "signUp-alert-username", "signUp-alert-agree", "signUp-alert-success", "signUp-alert-error"));

            return $parameters;
        }

    }

?>