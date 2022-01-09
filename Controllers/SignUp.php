<?php

    namespace Static\Controllers;

    final class SignUp extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript(\Static\Kernel::getPath("/Public/Scripts/SignUp.js"));

            if($parameters["userID"] >= 1) {
                header("Location: " . \Static\Kernel::getPath("/"));

                exit();
            }

            return $parameters;
        }

    }

?>