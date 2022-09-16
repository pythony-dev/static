<?php

    namespace Static\Controllers;

    final class Messages extends Main {

        public static function start($parameters) {
            if($parameters["userID"] < 1) {
                header("Location: " . \Static\Kernel::getPath("/log-in"));

                exit();
            }

            \Static\Kernel::addScript("/Public/Scripts/Messages.js");

            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "messages-alert-message-error",
                "messages-alert-delete-ask", "messages-alert-delete-success", "messages-alert-delete-error",
            ));

            return $parameters;
        }

    }

?>