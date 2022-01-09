<?php

    $action = \Static\Kernel::getValue($_POST, "action");
    $email = \Static\Kernel::getValue($_POST, "email");
    $username = \Static\Kernel::getValue($_POST, "username");
    $password = \Static\Kernel::getValue($_POST, "password");

    if($action == "isEmail") echo \Static\Models\Users::isEmail($email);
    else if($action == "isUsername") echo \Static\Models\Users::isUsername($username);
    else if($action == "signUp" && \Static\Models\Users::signUp($email, $username)) echo "true";
    else if($action == "logIn" && \Static\Models\Users::logIn($email, $password)) echo "true";
    else if($action == "reset" && \Static\Models\Users::reset($email)) echo "true";
    else if($action == "logOut") {
        $_SESSION["userID"] = null;

        echo "true";
    }

?>