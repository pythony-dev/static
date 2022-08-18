<?php

    namespace Static\Controllers;

    abstract class Main {

        static public function start($parameters) {
            \Static\Kernel::addStyle("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css");
            \Static\Kernel::addStyle("/Public/Styles/Index.css");

            \Static\Kernel::addScript("https://code.jquery.com/jquery-3.5.0.min.js");
            \Static\Kernel::addScript("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js");
            \Static\Kernel::addScript("/Public/Scripts/Index.js");

            $parameters["modals"] = array();
            $parameters["alerts"] = array("index-alert-language", "index-alert-logOut", "index-alert-token");

            return $parameters;
        }

    }

?>