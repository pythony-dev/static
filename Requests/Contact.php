<?php

    namespace Static\Requests;

    final class Contact {

        public static function create() {
            $email = \Static\Kernel::getValue($_POST, "email");
            $message = \Static\Kernel::getValue($_POST, "message");

            return array(
                "status" => \Static\Models\Contact::create($email, $message),
            );
        }

    }

?>