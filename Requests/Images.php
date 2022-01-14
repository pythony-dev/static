<?php

    $id = \Static\Kernel::getValue($_SESSION, "userID");

    if($id >= 1 && array_key_exists("image", $_FILES)) {
        $image = $_FILES["image"];

        if(!in_array(pathinfo($image["name"])["extension"], array("png", "jpg", "jpeg"))) echo "extension";
        else if(!in_array($image["type"], array("image/png", "image/jpg", "image/jpeg"))) echo "type";
        else if($image["size"] >= 1048576) echo "size";
        else if(move_uploaded_file($image["tmp_name"], "Public/Images/Users/" . $id . ".png")) echo "success";
    }

?>