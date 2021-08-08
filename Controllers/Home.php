<?php

    namespace Static\Controllers;

    final class Home extends Main {

        public static function start($parameters) {
            $parameters["themes"] = array("Models", "Views", "Controllers", "Requests", "Translate", "Emails");

            return $parameters;
        }

    }

?>