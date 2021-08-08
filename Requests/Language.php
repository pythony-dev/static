<?php

    $language = \Static\Kernel::getValue($_POST, "language");

    if(!empty($language) && in_array($language, \Static\Languages\Translate::getAllLanguages())) {
        $_SESSION["language"] = $language;

        echo "true";
    }

?>