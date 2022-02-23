<?php

    namespace Static\Controllers;

    final class Privacy extends Main {

        public static function start($parameters) {
            $parameters["privacy"] = array("Introduction", "GDPR", "Log", "Policies", "Third", "Children", "Online", "Consent");

            return $parameters;
        }

    }

?>