<?php

    namespace Static\Controllers;

    final class Messages extends Main {

        public static function start($parameters) {
            if($parameters["userID"] <= 0) {
                header("Location: " . \Static\Kernel::getPath("/log-in"));

                exit();
            }

            \Static\Kernel::addScript("/Public/Scripts/Messages.js");
            \Static\Kernel::addScript("/Public/Scripts/Search.js");

            $parameters["modals"] = array_merge($parameters["modals"], array("search"));
            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "messages-alert-message-error",
                "messages-alert-block-ask", "messages-alert-block-success", "messages-alert-block-error",
                "messages-alert-delete-ask", "messages-alert-delete-error",
                "search-alert-search-error",
                "search-alert-block-ask", "search-alert-block-success", "search-alert-block-error",
            ));

            return $parameters;
        }

    }

?>