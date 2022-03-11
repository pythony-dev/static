<?php

    namespace Static\Models;

    use PDO;

    final class Features extends Database {

        public static function getFeatures() {
            $query = parent::$pdo->prepare("SELECT ID, Title, Subtitle, Content FROM Features WHERE Language = :language ORDER BY ID DESC");
            $query->bindValue(":language", \Static\Languages\Translate::getLanguage(), PDO::PARAM_STR);
            $query->execute();

            $results = array();

            while($feature = $query->fetch()) {
                array_push($results, array(
                    "image" => \Static\Kernel::getPath("/Public/Images/Features/" . (int)(\Static\Kernel::getValue($feature, "ID") / 2 + .5) . ".jpeg"),
                    "title" => $feature["Title"],
                    "subtitle" => $feature["Subtitle"],
                    "content" => $feature["Content"],
                ));
            }

            return $results;
        }

    }

?>