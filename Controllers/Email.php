<?php

    namespace Static\Controllers;

    final class Email extends Main {

        public static function start($parameters) {
            if(!($email = \Static\Models\Emails::getEmail(\Static\Kernel::getValue($parameters, "link")))) {
                header("Location: " . \Static\Kernel::getPath("/"));

                exit();
            }

            $parameters["title"] = htmlspecialchars_decode(\Static\Kernel::getValue($email, "title"));
            $parameters["content"] = htmlspecialchars_decode(htmlspecialchars_decode(\Static\Kernel::getValue($email, "content")));
            $parameters["email"] = \Static\Kernel::getValue($email, "email");
            $parameters["date"] = date_format(date_create(\Static\Kernel::getValue($email, "created")), substr(\Static\Kernel::getDateFormat(), 0, 5));
            $parameters["time"] = date_format(date_create(\Static\Kernel::getValue($email, "created")), substr(\Static\Kernel::getDateFormat(), 5));

            return $parameters;
        }

    }

?>