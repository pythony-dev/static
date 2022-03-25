<?php

    namespace Static\Requests;

    final class Images {

        public static function upload() {
            $parameters = array();

            $id = \Static\Kernel::getValue($_SESSION, "userID");

            if($id < 1) $parameters["status"] = "user ID";
            else if(array_key_exists("image", $_FILES)) {
                $image = $_FILES["image"];

                if(!in_array(pathinfo($image["name"])["extension"], array("PNG", "JPG", "JPEG", "png", "jpg", "jpeg"))) $parameters["status"] = "extension";
                else if(!in_array($image["type"], array("image/png", "image/jpg", "image/jpeg"))) $parameters["status"] = "type";
                else if($image["size"] >= 1048576) $parameters["status"] = "size";
                else if(move_uploaded_file($image["tmp_name"], "Public/Images/Users/" . $id . ".jpeg")) $parameters["status"] = "success";
                else $parameters["status"] = "error";
            } else $parameters["status"] = "image";

            return $parameters;
        }

    }

?>