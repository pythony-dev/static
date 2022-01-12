<?php

    namespace Static\Controllers;

    final class Settings extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript(\Static\Kernel::getPath("/Public/Scripts/Settings.js"));

            if($parameters["userID"] < 1) {
                header("Location: " . \Static\Kernel::getPath("/log-in"));

                exit();
            }

            $parameters["user"] = \Static\Models\Users::getUser();

            return $parameters;
        }

    }

?>