<?php

    namespace Static\Controllers;

    final class LogIn extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript(\Static\Kernel::getPath("/Public/Scripts/LogIn.js"));

            if($parameters["userID"] >= 1) {
                header("Location: " . \Static\Kernel::getPath("/settings"));

                exit();
            }

            return $parameters;
        }

    }

?>