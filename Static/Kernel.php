<?php

    namespace Static;

    final class Kernel {

        private static $version = "1.2.0";

        private static $link = "";
        private static $styles = array();
        private static $scripts = array();
        private static $routes = array();
        private static $requests = array();
        private static $route = "";

        private static $salt = "";

        public static function setLink($link) {
            self::$link = htmlspecialchars($link);
        }

        public static function addStyle($style) {
            array_push(self::$styles, htmlspecialchars($style));
        }

        public static function addScript($script) {
            array_push(self::$scripts, htmlspecialchars($script));
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

        public static function setSalt($salt) {
            self::$salt = htmlspecialchars($salt);
        }

        public static function getValue($array, $keys) {
            if(!is_array($keys) && array_key_exists($keys, $array)) return htmlspecialchars($array[$keys]);
            else if(is_array($keys) && count($keys) == 1 && array_key_exists($keys[0], $array)) return htmlspecialchars($array[$keys[0]]);
            else if(is_array($keys) && count($keys) > 1) {
                $key = array_shift($keys);

                if(array_key_exists($key, $array)) return self::getValue($array[$key], $keys);
            } else return null;
        }

        public static function getPath($path) {
            $path = htmlspecialchars($path);

            if(empty($path) || (strlen($path) > 0 && $path[0] == "/")) return self::$link . $path;
            else return $path;
        }

        public static function getDateFormat() {
            return "d/m/Y H:i:s";
        }

        public static function start() {
            if(!\Static\Models\Requests::check()) return self::setError(429, "Too Many Requests");
            else if(!array_key_exists("request", $_POST)) {
                self::addRoute("error", "/error/(error)");

                $start = strlen(self::$link) + 1;
                $search = explode("/", substr((array_key_exists("HTTPS", $_SERVER) ? "https" : "http") . "://" . htmlspecialchars($_SERVER["HTTP_HOST"] . $_SERVER["REDIRECT_URL"]), $start));

                foreach(self::$routes as $route) {
                    $path = explode("/", substr(self::$link . $route["path"], $start));

                    if(count($search) != count($path)) continue;

                    $parameters = array();
                    $found = true;

                    foreach($search as $id => $action) {
                        if(empty($action) && empty($path[$id])) break;
                        else if(empty($action) || count($path) <= $id || strlen($path[$id]) <= 0) $found = false;
                        else if($path[$id][0] == "(" && $path[$id][strlen($path[$id]) - 1] == ")") {
                            $value = substr($path[$id], 1, -1);

                            if(empty($value)) $found = false;
                            else $parameters[$value] = $action;
                        }

                        else if($action != $path[$id]) $found = false;
                    }

                    if($found) {
                        self::$route = ucfirst($route["name"]);

                        if(self::$route == "Error") return self::setError(array_key_exists("error", $parameters) ? $parameters["error"] : 500, "Internal Server Error");

                        $view = "Views/" . self::$route . ".php";
                        $controller = "\Static\Controllers\\" . self::$route;

                        if(!file_exists($view)) return self::setError(404, "No View : " . $view);
                        else if(!class_exists($controller)) return self::setError(404, "No Controller : " . $controller);

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

                return self::setError(404, "No Route : " . self::getValue($_SERVER, "REDIRECT_URL"));
            } else {
                $search = htmlspecialchars($_POST["request"]);

                if(self::$requests[array_search($search, array_column(self::$requests, "name"))]["secure"] && !\Static\Models\Tokens::check()) return self::setError(401, "Invalid Token");

                foreach(self::$requests as $request) {
                    if($search == $request["name"]) {
                        $request = "Requests/" . ucfirst($request["name"]) . ".php";

                        if(!file_exists($request)) return self::setError(404, "No Request : " . $request);

                        require_once($request);

                        return;
                    }
                }

                return self::setError(404, "No Request : " . $search);
            }
        }

        public static function setError($error, $text) {
            $parameters = \Static\Controllers\Error::start(array_merge(self::getParameters(), array(
                "error" => (int)$error,
                "text" => htmlspecialchars($text),
            )));

            http_response_code(array_key_exists("error", $parameters) ? (int)$parameters["error"] : 500);

            ob_start();
            require_once("Views/Error.php");
            $body = ob_get_contents();
            ob_end_clean();

            $title = array_key_exists("title", $parameters) ? $parameters["title"] : "Error";
            $styles = self::$styles;
            $scripts = self::$scripts;
            require_once("Views/Index.php");

            exit();
        }

        public static function getParameters() {
            return array(
                "userID" => self::getValue($_SESSION, "userID"),
                "title" => \Static\Languages\Translate::getText("navbar-" . lcfirst(self::$route)),
                "getText" => "\Static\Languages\Translate::getText",
                "getPath" => "\Static\Kernel::getPath",
            );
        }

    }

?>