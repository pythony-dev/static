<?php

    if(!array_key_exists("userID", $_SESSION)) \Static\Models\Users::create();

    \Static\Models\Views::create(\Static\Kernel::getValue($_POST, "link"), \Static\Kernel::getValue($_POST, "referer"));

?>