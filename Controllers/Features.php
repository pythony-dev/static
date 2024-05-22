<?php

    namespace Static\Controllers;

    final class Features extends Main {

        public static function start($parameters) {
            if($parameters["userID"] >= 1) {
                header("Location: " . \Static\Kernel::getPath("/settings"));

                exit();
            }

            return $parameters;
        }

    }

?>