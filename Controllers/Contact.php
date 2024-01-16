<?php

    namespace Static\Controllers;

    final class Contact extends Main {

        public static function start($parameters) {
            \Static\Kernel::addScript("/Public/Scripts/Contact.js");

            $parameters["email"] = \Static\Kernel::getValue(\Static\Models\Users::getUser($parameters["userID"]), "email");

            $parameters["alerts"] = array_merge($parameters["alerts"], array("contact-alert-email", "contact-alert-success", "contact-alert-error"));

            return $parameters;
        }

    }

?>