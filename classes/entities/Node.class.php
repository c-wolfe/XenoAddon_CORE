<?php
    /**
     * Copyright 2018 Cameron Wolfe
     *
     * Licensed under the Apache License, Version 2.0 (the "License");
     * you may not use this file except in compliance with the License.
     * You may obtain a copy of the License at
     *
     * http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software
     * distributed under the License is distributed on an "AS IS" BASIS,
     * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     * See the License for the specific language governing permissions and
     * limitations under the License.
     */


    namespace Cameron\XenoPanel\Addons\Core\Entities;

    /**
     * Class CNode
     *
     * Can't even use reserved class names, even if they're in their own namespace -_-
     *
     * @package Cameron\XenoPanel\Addons\Core\Entities
     */
    class CNode {

        private static $api;
        /** @var array */
        private static $node;
        /** @var  string */
        protected $name;

        /**
         * CNode constructor.
         *
         * @param $node array APIv2 object of the node
         */
        public function __construct($node = null) {
            self::$api = $GLOBALS['Node'];
            self::$node = $node;
            $this->name = $node['name'];
        }

        /**
         * Get a CNode class instance of a node, searching using a node name. Will return null if we failed to
         * find one.
         *
         * @param $name string Name of the node to search for
         *
         * @return $this CNode|null
         */
        public static function fromName($name) {

            $api = $GLOBALS['Node'];
            $result = $api->node($name);
            if ($result instanceof \SplBool && !$result) {
                return null;
            }
            self::$api = $api;

            $node = new CNode($result);
            $node->name = $name;

            return $node;
        }

        /**
         * @param $port
         *
         * @return array
         */
        public function getIPWithPortAvailable($port) {
            $ips = $this->getIPsWithPortAvailable($port);

            return sizeof($ips) == 0 ? [] : $ips[0];
        }

        /**
         * @param int  $port
         * @param bool $include_main
         *
         * @return array
         */
        public function getIPsWithPortAvailable($port, $include_main = true) {
            $ips = $this->getIPs($include_main);
            $aips = [];
            foreach ($ips as $ip) {
                if ($this->isPortAvailable($port, $ip)) {
                    $aips[ sizeof($aips) ] = $ip;
                }
            }

            return $aips;
        }

        /**
         * Gets the list of ips of a node that meet the given parameters.
         *
         * @param bool $include_main
         *
         * @return array
         */
        public function getIPs($include_main = true) {
            return explode(',', self::$api->get_ips($this->joining(), $include_main));
        }

        /**
         * @param array $array
         *
         * @return array
         */
        private function joining($array = []) {
            return array_merge(['name' => $this->getName()], $array);
        }

        /**
         * @return string
         */
        public function getName() {
            return $this->name;
        }

        /**
         * @param int         $port
         * @param null|string $ip
         *
         * @return boolean
         */
        public function isPortAvailable($port, $ip = null) {
            return $ip == null ? self::$api->is_port_available($this->joining(), $port) : self::$api->is_port_available($this->joining(), $port, $ip);
        }

        /**
         * @param Filter $filter
         *
         * @return array
         */
        public function getServers($filter = null) {
            return $filter == null ? self::$api->get_servers($this->joining()) : self::$api->get_servers($this->joining(), $filter->getWhere(), $filter->getValue());
        }

        /**
         * Gets the default global limits for any servers on the given node.
         *
         * @return array
         */
        public function getLimits() {
            $result = self::$api->get_global_limit($this->joining());

            return ($result instanceof \SplBool && !$result) ? [] : $result;
        }

        /**
         * Sets the default global limits for any servers on the given node.
         *
         * @param double $cores
         * @param double $cpu_limit
         * @param double $cpu_children
         */
        public function setLimits($cores, $cpu_limit, $cpu_children) {
            self::$api->set_global_limit($this->joining(), $cores, $cpu_limit, $cpu_children);
        }

        /**
         * Gets the current and total memory values. (Based on the Status Monitoring CRON)
         *
         * @return array
         */
        public function getMemoryDetails() {
            $result = self::$api->get_memory_details($this->joining());

            return ($result instanceof \SplBool && !$result) ? [] : $result;
        }

        /**
         * Gets the current and total storage values. (Based on the Status Monitoring CRON)
         *
         * @return array
         */
        public function getStorageDetails() {
            $result = self::$api->get_storage_details($this->joining());

            return ($result instanceof \SplBool && !$result) ? [] : $result;
        }

        /**
         *  Gets the list of games of a node that meet the given parameters.
         *
         * @return array
         */
        public function getGames() {
            $result = self::$api->get_gamemodes($this->joining());

            return ($result instanceof \SplBool && !$result) ? [] : $result;
        }

        /**
         * Gets the set location of the seleted node.
         *
         * @return string
         */
        public function getLocation() {
            $result = self::$api->get_location($this->joining());

            return ($result instanceof \SplBool && !$result) ? "__" : $result;
        }

        /**
         * Sets the location of the selected node.
         *
         * @param string $location
         */
        public function setLocation($location) {
            self::$api->set_location($this->joining(), $location);
        }

        /**
         * Detected if the node is being used for private managing.
         *
         * @return boolean
         */
        public function isPrivate() {
            return self::$api->is_private($this->joining());
        }

    }