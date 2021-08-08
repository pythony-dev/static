<?php

    namespace Static\Controllers;

    final class Contact extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript(\Static\Kernel::getPath("/Public/Scripts/Contact.js"));

            return $parameters;
        }

    }

?>