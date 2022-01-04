<?php

    if(!array_key_exists("sessionID", $_SESSION)) \Static\Models\Sessions::create();

    \Static\Models\Views::create(\Static\Kernel::getValue($_POST, "link"), \Static\Kernel::getValue($_POST, "referer"));

?>