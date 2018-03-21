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
     * Class CServer
     *
     * @package Cameron\XenoPanel\Addons\Core\Entities
     */
    class CServer {

        private static $api;
        /** @var array|null */
        private static $server;
        /** @var  int */
        protected $id;

        /**
         * CServer constructor.
         *
         * @param array|null $server
         */
        public function __construct($server = null) {
            self::$api = $GLOBALS['Server'];
            self::$server = $server;
            $this->id = $server['ID'];
        }

        /**
         * @param int $id
         *
         * @return CServer|null
         */
        public static function fromID($id) {
            $api = $GLOBALS['Server'];
            $result = $api->server($id);
            if ($result instanceof \SplBool && !$result) {
                return null;
            }
            self::$api = $api;

            $server = new CServer($result);
            $server->id = $id;

            return $server;
        }

        /**
         *  Check if a server is currently suspended
         *
         * @return boolean
         */
        public function isSuspended() {
            return self::$api->is_suspended($this->joining());
        }

        /**
         * @param array $array
         *
         * @return array
         */
        private function joining($array = []) {
            return array_merge(['ID' => $this->getId()], $array);
        }

        /**
         * @return int
         */
        public function getId() {
            return $this->id;
        }

        /**
         *  Check if a server is currently online. (Updated every 5 minutes)
         *
         * @return boolean
         */
        public function isOnline() {
            return self::$api->is_online($this->joining());
        }

        /**
         * Sets the server to suspended true.
         */
        public function suspend() {
            self::$api->suspend($this->joining());
        }

        /**
         * Sets the server to suspended false.
         */
        public function unsuspend() {
            self::$api->unsuspend($this->joining());
        }

        /**
         * Check if a server can change the slot amount or not.
         *
         * @return boolean
         */
        public function canChangeSlots() {
            return self::$api->can_change_slots($this->joining());
        }

        /**
         * Gets the jar of the server ID provided.
         *
         * @return string
         */
        public function getJar() {
            $result = self::$api->get_jar($this->joining());

            return ($result instanceof \SplBool && !$result) ? "" : $result;
        }

        /**
         * Sets the jar of the server ID provided.
         *
         * @param string $jar
         */
        public function setJar($jar) {
            self::$api->set_jar($this->joining(), $jar);
        }

        /**
         * Gets the ip of the server ID provided.
         *
         * @return string
         */
        public function getIP() {
            $result = self::$api->get_ip($this->joining());

            return ($result instanceof \SplBool && !$result) ? "" : $result;
        }

        /**
         * Sets the ip of the server ID provided.
         *
         * @param string $ip
         */
        public function setIP($ip) {
            self::$api->set_ip($this->joining(), $ip);
        }

        /**
         * Gets the port of the server ID provided.
         *
         * @return int
         */
        public function getPort() {
            $result = self::$api->get_port($this->joining());

            return ($result instanceof \SplBool && !$result) ? -1 : $result;
        }

        /**
         * Sets the port of the server ID provided.
         *
         * @param int $port
         */
        public function setPort($port) {
            self::$api->set_port($this->joining(), $port);
        }

        /**
         * Gets the name of the server ID provided.
         *
         * @return string
         */
        public function getName() {
            $result = self::$api->get_name($this->joining());

            return ($result instanceof \SplBool && !$result) ? "" : $result;
        }

        /**
         *  Sets the name of the server ID provided.
         *
         * @param string $name
         */
        public function setName($name) {
            self::$api->set_name($this->joining(), $name);
        }

        /**
         * Gets the slots of the server ID provided.
         *
         * @return int
         */
        public function getSlots() {
            $result = self::$api->get_slots($this->joining());

            return ($result instanceof \SplBool && !$result) ? -1 : $result;
        }

        /**
         * Sets the slots of the server ID provided.
         *
         * @param int $port
         */
        public function setSlots($port) {
            self::$api->set_slots($this->joining(), $port);
        }

        /**
         * Gets the memory of the server ID provided.
         *
         * @return int
         */
        public function getMemory() {
            $result = self::$api->get_memory($this->joining());

            return ($result instanceof \SplBool && !$result) ? -1 : $result;
        }

        /**
         * Sets the memory of the server ID provided.
         *
         * @param int $memory
         */
        public function setMemory($memory) {
            self::$api->set_memory($this->joining(), $memory);
        }

        /**
         * Gets the node of the server ID provided.
         *
         * @return CNode
         */
        public function getNode() {
            $result = self::$api->get_name($this->joining());

            return ($result instanceof \SplBool && !$result) ? null : new CNode($result);
        }

        /**
         * Gets the startup variables of the server ID provided.
         *
         * @return array
         */
        public function getVariables() {
            $result = self::$api->get_variables($this->joining());

            return ($result instanceof \SplBool && !$result) ? [] : $result;
        }

        /**
         * Gets the startup variable of the server ID provided.
         *
         * @param string $variable
         *
         * @return null|string
         */
        public function getVariable($variable) {
            $result = self::$api->get_variable($this->joining(), $variable);

            return ($result instanceof \SplBool && !$result) ? null : $result;
        }

    }