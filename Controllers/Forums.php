<?php

    namespace Static\Controllers;

    final class Forums extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript("/Public/Scripts/Forums.js");

            $parameters["page"] = array_key_exists("page", $parameters) ? (int)$parameters["page"] : 1;
            $parameters["limit"] = ceil(\Static\Models\Threads::count() / 10);

            if($parameters["page"] > $parameters["limit"] || $parameters["page"] < 1) {
                header("Location: " . \Static\Kernel::getPath("/forums"));

                exit();
            }

            $parameters["threads"] = \Static\Models\Threads::getThreads($parameters["page"]);

            if($parameters["userID"] >= 1) {
                \Static\Kernel::addScript("/Public/Scripts/Create.js");

                $parameters["modals"] = array_merge($parameters["modals"], array("create"));
            }

            $parameters["alerts"] = array_merge($parameters["alerts"], array(
                "forums-alert-report-success", "forums-alert-report-error",
                "forums-alert-delete-ask", "forums-alert-delete-success", "forums-alert-delete-error",
                "create-alert-success-thread", "create-alert-error-thread",
                "upload-alert-extension", "upload-alert-type", "upload-alert-size", "upload-alert-success", "upload-alert-error",
            ));

            return $parameters;
        }

    }

?>