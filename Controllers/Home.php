<?php

    namespace Static\Controllers;

    final class Home extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript("https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js");
            \Static\Kernel::addScript("/Public/Scripts/Home.js");

            $parameters["themes"] = array("Why", "Framework", "Time", "Templates", "Components", "Productivity", "Translations", "Themes");
            $parameters["charts"] = array($parameters["themes"][2], $parameters["themes"][5]);

            return $parameters;
        }

    }

?>