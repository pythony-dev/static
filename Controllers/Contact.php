<?php

    namespace Static\Controllers;

    final class Contact extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript(\Static\Kernel::getPath("/Public/Scripts/Contact.js"));

            $parameters["alerts"] = array_merge($parameters["alerts"], array("contact-alert-email", "contact-alert-message", "contact-alert-success", "contact-alert-error"));

            return $parameters;
        }

    }

?>