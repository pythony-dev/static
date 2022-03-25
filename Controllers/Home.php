<?php

    namespace Static\Controllers;

    final class Home extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript("https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js");
            \Static\Kernel::addScript(\Static\Kernel::getPath("/Public/Scripts/Home.js"));

            $parameters["themes"] = array("Models", "Views", "Time", "Controllers", "Requests", "Productivity", "Translate", "Emails");

            return $parameters;
        }

    }

?>