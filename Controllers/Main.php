<?php

    namespace Static\Controllers;

    abstract class Main {

        static public function start($parameters) {
            \Static\Kernel::addStyle("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css");
            \Static\Kernel::addStyle(\Static\Kernel::getPath("/Public/Styles/Index.css"));

            \Static\Kernel::addScript("https://code.jquery.com/jquery-3.5.0.min.js");
            \Static\Kernel::addScript("https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js");
            \Static\Kernel::addScript(\Static\Kernel::getPath("/Public/Scripts/Index.js"));

            \Static\Kernel::setSalt("0123456789ABCDEF");
        }

    }

?>