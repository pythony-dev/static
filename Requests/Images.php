<?php

    namespace Static\Requests;

    final class Images {

        public static function upload() {
            $response = "error";

            $imageID = \Static\Kernel::getValue($_SESSION, "userID");
            $folder = ucfirst(\Static\Kernel::getValue($_POST, "folder"));

            if($imageID >= 1 && in_array($folder, array("Posts", "Users")) && array_key_exists("image", $_FILES)) {
                if($folder != "Users") $imageID = \Static\Models\Users::createPassword();

                $path = "Public/Images/" . $folder . "/" . \Static\Kernel::getHash(substr($folder, 0, -1), $imageID) . ".jpeg";

                $image = $_FILES["image"];

                if(!in_array(pathinfo($image["name"])["extension"], array("JPG", "JPEG", "PNG", "jpg", "jpeg", "png"))) $response = "extension";
                else if(!in_array($image["type"], array("image/jpg", "image/jpeg", "image/png"))) $response = "type";
                else if($image["size"] >= 1048576) $response = "size";
                else if(move_uploaded_file($image["tmp_name"], $path)) {
                    $response = array(
                        "status" => "success",
                        "path" => \Static\Kernel::getPath("/" . $path),
                        "hash" => \Static\Kernel::getHash(substr($folder, 0, -1), $imageID),
                    );
                }
            }

            return is_array($response) ? $response : array(
                "status" => $response,
            );
        }

    }

?>