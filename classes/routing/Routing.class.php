<?php


    namespace Cameron\XenoPanel\Addons\Core\Routing;

    use Cameron\XenoPanel\Addons\Core\Addon;

    /**
     * Class Routing
     *
     * @package Cameron\XenoPanel\Addons\Core\Routing
     */
    class Routing {

        /** @var Addon $addon */
        private $addon;
        /** @var array */
        private $routes;
        /** @var array */
        private $default_routes;

        public function __construct($addon) {
            $this->addon = $addon;
        }

        /**
         * Load routes into our array so that we can handle them
         */
        public function loadRoutes() {

            $raw_routes = json_decode(file_get_contents($this->addon->getDirectory() . '/routing.json'), true);

            foreach ($raw_routes as $route) {
                $this->routes[ $route['route'] ] = $route['location'];
            }
        }

        /**
         * Save our default routes
         */
        public function saveDefaultRoutes() {

            foreach (array_keys($this->getDefaultRoutes()) as $route) {
                if (!$this->doesRouteExist($route)) {
                    $this->addRoute($route, $this->routes[ $route ]);
                }
            }

        }

        /**
         * @return array Default routes that we should save if they don't exist
         */
        public function getDefaultRoutes() {
            return $this->default_routes;
        }

        /**
         * @param array $default_routes
         */
        public function setDefaultRoutes($default_routes) {
            $this->default_routes = $default_routes;
        }

        /**
         * Check whether a route exists in the file or not
         *
         * @param $route
         *
         * @return bool
         */
        public function doesRouteExist($route) {
            return isset($this->routes[ $route ]);
        }

        /**
         * Add a route to our `routing.json` file
         *
         * @param      $route
         * @param      $location
         * @param bool $save
         *
         */
        public function addRoute($route, $location, $save = false) {
            $this->routes[ $route ] = $location;
            if ($save) $this->saveRoutes();
        }

        /**
         * Save our routes array to flatfile
         */
        public function saveRoutes() {

            $raw_routes = [];
            foreach (array_keys($this->routes) as $route) {
                $raw_route = [];
                $raw_route['route'] = $route;
                $raw_route['location'] = $this->routes[ $route ];
                $raw_routes[ sizeof($raw_routes) ] = $raw_route;
            }

            file_put_contents($this->addon->getDirectory() . '/routing.json', json_encode($raw_routes));
        }

        /**
         * Remove a route from our `routing.json` file
         *
         * @param      $route
         * @param bool $save
         */
        public function removeRoute($route, $save = false) {
            unset($this->routes[ $route ]);
            if ($save) $this->saveRoutes();
        }

    }