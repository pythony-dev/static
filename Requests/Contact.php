<?php

    namespace Static\Requests;

    final class Contact {

        public static function create() {
            $email = \Static\Kernel::getValue($_POST, "email");
            $message = \Static\Kernel::getValue($_POST, "message");

            return \Static\Kernel::getRequest(\Static\Models\Contact::create($email, $message));
        }

    }

?>