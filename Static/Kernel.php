<?php

    namespace Static;

    final class Kernel {

        private static $version = "1.4.1";
        private static $settings = array();

        private static $styles = array();
        private static $scripts = array();
        private static $routes = array();
        private static $requests = array();
        private static $route = "";

        private static $salt = "0123456789ABCDEF";

        public static function addStyle($style, $encode = true) {
            array_push(self::$styles, $encode ? htmlspecialchars($style) : $style);
        }

        public static function addScript($script, $encode = true) {
            array_push(self::$scripts, $encode ? htmlspecialchars($script) : $script);
        }

        public static function addRoute($name, $path) {
            array_push(self::$routes, array(
                "name" => htmlspecialchars($name),
                "path" => htmlspecialchars($path),
            ));
        }

        public static function addRequest($name, $secure) {
            array_push(self::$requests, array(
                "name" => htmlspecialchars($name),
                "secure" => boolval($secure),
            ));
        }

        public static function getRoute() {
            return self::$route;
        }

        public static function getSalt() {
            return self::$salt;
        }

        public static function getValue($array, $keys) {
            if(!is_array($keys) && array_key_exists($keys, $array)) return htmlspecialchars($array[$keys]);
            else if(is_array($keys) && count($keys) == 1 && array_key_exists($keys[0], $array)) return htmlspecialchars($array[$keys[0]]);
            else if(is_array($keys) && count($keys) > 1) {
                $key = array_shift($keys);

                if(array_key_exists($key, $array)) return self::getValue($array[$key], $keys);
                else return null;
            } else return null;
        }

        public static function getSettings($settings) {
            $settings = \Static\Kernel::getValue(self::$settings, $settings);

            foreach(self::$settings as $key => $value) $settings = str_replace("@" . $key, htmlspecialchars($value), $settings);

            return $settings;
        }

        public static function getPath($path, $encode = true) {
            $path = $encode ? htmlspecialchars($path) : $path;

            if(empty($path) || (strlen($path) > 0 && $path[0] == "/")) return self::getSettings("settings-link") . $path;
            else return $path;
        }

        public static function getID($id) {
            return (int)(($id - 1) / count(\Static\Languages\Translate::getAllLanguages())) + 1;
        }

        public static function getParameters() {
            return array(
                "userID" => self::getValue($_SESSION, "userID"),
                "title" => \Static\Languages\Translate::getText("title-" . lcfirst(self::$route)),
                "getSettings" => "\Static\Kernel::getSettings",
                "getPath" => "\Static\Kernel::getPath",
                "getText" => "\Static\Languages\Translate::getText",
            );
        }

        public static function getDateFormat() {
            return "d/m/Y H:i:s";
        }

        public static function start() {
            if(file_exists("Static/Settings.json")) self::$settings = (array)json_decode(file_get_contents("Static/Settings.json"));
            else exit();

            \Static\Models\Database::connect();
            \Static\Languages\Translate::setLanguage();

            if(!\Static\Models\Sessions::start() || !\Static\Models\Requests::start()) return self::setError(429, \Static\Languages\Translate::getText("error-requests"), false);
            else if(!array_key_exists("request", $_POST)) {
                self::addRoute("error", "/error/(error)");

                $start = strlen(self::getSettings("settings-link")) + 1;
                $search = explode("/", substr((array_key_exists("HTTPS", $_SERVER) ? "https" : "http") . "://" . self::getValue($_SERVER, "HTTP_HOST") . self::getValue($_SERVER, "REDIRECT_URL"), $start));

                foreach(self::$routes as $route) {
                    $path = explode("/", substr(self::getSettings("settings-link") . $route["path"], $start));

                    if(count($path) != count($search)) continue;

                    $parameters = array();
                    $found = true;

                    foreach($search as $id => $action) {
                        if(empty($action) && empty($path[$id])) break;
                        else if(empty($action) || count($path) <= $id || strlen($path[$id]) <= 0) $found = false;
                        else if($path[$id][0] == "(" && $path[$id][strlen($path[$id]) - 1] == ")") {
                            $value = substr($path[$id], 1, -1);

                            if(empty($value)) $found = false;
                            else $parameters[$value] = $action;
                        } else if($action != $path[$id]) $found = false;
                    }

                    if($found) {
                        self::$route = ucfirst($route["name"]);

                        if(self::$route == "Error") return self::setError(array_key_exists("error", $parameters) ? $parameters["error"] : 500, \Static\Languages\Translate::getText("error-internal"), false);

                        $view = "Views/" . self::$route . ".php";
                        $controller = "\Static\Controllers\\" . self::$route;

                        if(!file_exists($view)) return self::setError(404, \Static\Languages\Translate::getText("error-view") . $view, false);
                        else if(!class_exists($controller)) return self::setError(404, \Static\Languages\Translate::getText("error-controller") . $controller, false);

                        $parameters = \Static\Controllers\Main::start($parameters);
                        $parameters = $controller::start(array_merge(self::getParameters(), $parameters));

                        ob_start();
                        require_once($view);
                        $body = ob_get_contents();
                        ob_end_clean();

                        $title = array_key_exists("title", $parameters) ? $parameters["title"] : self::$route;
                        $styles = self::$styles;
                        $scripts = self::$scripts;

                        require_once("Views/Index.php");

                        return;
                    }
                }

                return self::setError(404, \Static\Languages\Translate::getText("error-route") . self::getValue($_SERVER, "REDIRECT_URL"), false);
            } else {
                header("Content-Type: application/json");

                self::addRequest("tokens", false);
                self::addRequest("start", false);
                self::addRequest("language", false);

                $search = htmlspecialchars($_POST["request"]);

                if(\Static\Kernel::getSettings("project-environment") != "development" && self::$requests[array_search($search, array_column(self::$requests, "name"))]["secure"] && !\Static\Models\Tokens::check()) return self::setError(401, \Static\Languages\Translate::getText("error-token") . \Static\Kernel::getValue($_POST, "token"), true);

                foreach(self::$requests as $request) {
                    if($search == $request["name"]) {
                        $request = "\Static\Requests\\" . ucfirst($request["name"]);
                        $action = self::getValue($_POST, "action");

                        if(!class_exists($request)) return self::setError(404, \Static\Languages\Translate::getText("error-class") . $request, true);
                        if(!method_exists($request, $action)) return self::setError(404, \Static\Languages\Translate::getText("error-method") . $request . "::" . $action, true);

                        echo json_encode($request::$action());

                        return;
                    }
                }

                return self::setError(404, \Static\Languages\Translate::getText("error-request") . $search, true);
            }
        }

        public static function setError($error, $message, $request) {
            $parameters = \Static\Controllers\Main::start(array(
                "error" => (int)$error,
                "message" => htmlspecialchars($message),
            ));
            $parameters = \Static\Controllers\Error::start(array_merge(self::getParameters(), $parameters));

            http_response_code(array_key_exists("error", $parameters) ? (int)$parameters["error"] : 500);

            if($request) {
                echo json_encode(array(
                    "error" => (int)$parameters["error"],
                    "message" => htmlspecialchars($parameters["message"]),
                ));
            } else {
                ob_start();
                require_once("Views/Error.php");
                $body = ob_get_contents();
                ob_end_clean();

                $title = array_key_exists("title", $parameters) ? $parameters["title"] : "Error";
                $styles = self::$styles;
                $scripts = self::$scripts;

                require_once("Views/Index.php");
            }

            exit();
        }

    }

?>