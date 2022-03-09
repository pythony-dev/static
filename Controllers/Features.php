<?php

    namespace Static\Controllers;

    final class Features extends Main {

        public static function start($parameters) {
            $parameters["features"] = \Static\Models\Features::getFeatures();

            return $parameters;
        }

    }

?>