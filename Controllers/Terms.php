<?php

    namespace Static\Controllers;

    final class Terms extends Main {

        public static function start($parameters) {
            $parameters["terms"] = array("Introduction", "Property", "Restrictions", "Content", "Warranties", "Liability", "Indemnification", "Severability", "Variation", "Assignment", "Agreement", "Law", "Consent");

            return $parameters;
        }

    }

?>