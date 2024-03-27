<?php

    namespace Static\Requests;

    final class Images {

        public static function upload() {
            $error = null;

            $userID = \Static\Kernel::getValue($_SESSION, "userID");
            $folder = ucfirst(\Static\Kernel::getValue($_POST, "folder"));

            if($userID >= 1 && in_array($folder, array("Threads", "Posts", "Messages", "Users")) && array_key_exists("image", $_FILES)) {
                $imageID = $folder != "Users" ? rand(0, PHP_INT_MAX) : $userID;

                if($folder == "Threads") $folder = "Posts";

                $path = "Public/Images/" . $folder . "/" . \Static\Kernel::getHash(substr($folder, 0, -1), $imageID) . ".jpeg";

                $image = $_FILES["image"];

                if(!in_array(pathinfo($image["name"])["extension"], array("JPG", "JPEG", "PNG", "jpg", "jpeg", "png"))) $error = "extension";
                else if(!in_array($image["type"], array("image/jpg", "image/jpeg", "image/png"))) $error = "type";
                else if($image["size"] >= 1048576) $error = "size";
                else if(move_uploaded_file($image["tmp_name"], $path)) return array(
                    "status" => "success",
                    "path" => \Static\Kernel::getPath("/" . $path),
                    "hash" => \Static\Kernel::getHash(substr($folder, 0, -1), $imageID),
                );
            }

            return $error ? array(
                "status" => "error",
                "error" => $error,
            ) : "error";
        }

    }

?>