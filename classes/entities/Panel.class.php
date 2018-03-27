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
     * Class Panel
     *
     * @package Cameron\XenoPanel\Addons\Core\Entities
     */
    class CPanel {

        private static $api;

        public function __construct() {
            self::$api = $GLOBALS['Panel'];
        }

        /**
         * Gets the list of servers that meet the given parameters.
         *
         * @param Filter|null $filter
         *
         * @return array
         */
        public function getAllServers($filter = null) {
            $result = $filter == null ? self::$api->get_all_servers($this->joining()) : self::$api->get_all_servers($this->joining(), $filter->getWhere(), $filter->getValue());
            if (($result instanceof \SplBool && !$result)) return [];


            $servers = [];
            foreach ($result as $res) {
                $servers[ sizeof($servers) ] = new CServer($res);
            }

            return $servers;
        }

        /**
         * @param array $array
         *
         * @return array
         */
        private function joining($array = []) {
            return array_merge([], $array);
        }

        /**
         * Gets the list of nodes that meet the given parameters.
         *
         * @param Filter|null $filter
         *
         * @return array
         */
        public function getAllNodes($filter = null) {

            $result = $filter == null ? self::$api->get_all_nodes($this->joining()) : self::$api->get_all_nodes($this->joining(), $filter->getWhere(), $filter->getValue());
            if (($result instanceof \SplBool && !$result)) return [];

            $nodes = [];
            foreach ($result as $res) {
                $nodes[ sizeof($nodes) ] = new CNode($res);
            }

            return $nodes;
        }

        /**
         * Gets the list of users that meet the given parameters.
         *
         * @param Filter|null $filter
         *
         * @return array
         */
        public function getAllUsers($filter = null) {

            $result = $filter == null ? self::$api->get_all_users($this->joining()) : self::$api->get_all_users($this->joining(), $filter->getWhere(), $filter->getValue());
            if (($result instanceof \SplBool && !$result)) return [];

            $users = [];
            foreach ($result as $res) {
                $users[ sizeof($users) ] = new CUser($res);
            }

            return $users;
        }

        /**
         * Get a list of the latest actions by all users.
         *
         * @param int $count
         *
         * @return array
         */
        public function getLatestActions($count = 20) {
            $result = self::$api->get_latest_actions($count);
            if (($result instanceof \SplBool && !$result)) return [];

            return $result;
        }

        /**
         * Get a list of the alerts.
         *
         * @return array
         */
        public function getAlerts() {
            $result = self::$api->get_alerts();
            if (($result instanceof \SplBool && !$result)) return [];

            return $result;
        }

        /**
         * Get a list of all the statistics
         *
         * @return array
         */
        public function getStatistics() {
            $result = self::$api->get_statistics();
            if (($result instanceof \SplBool && !$result)) return [];

            return $result;
        }

        /**
         * Get a list of all the permissions a sub user can have.
         *
         * @return array
         */
        public function getSubUserPermissions() {
            $result = self::$api->get_sub_user_permissions();
            if (($result instanceof \SplBool && !$result)) return [];

            return $result;
        }

        /**
         * Gets the current version of the XenoPanel install.
         *
         * @return string
         */
        public function getVersion() {
            $result = self::$api->get_version();
            if (($result instanceof \SplBool && !$result)) return "UNKNOWN";

            return $result;
        }

        /**
         * Gets the current build of the XenoPanel install.
         *
         * @return string
         */
        public function getBuild() {
            $result = self::$api->get_build();
            if (($result instanceof \SplBool && !$result)) return "UNKNOWN";

            return $result;
        }

        /**
         * Gets the current commit of the XenoPanel install.
         *
         * @return string
         */
        public function getCommit() {
            $result = self::$api->get_commit();
            if (($result instanceof \SplBool && !$result)) return "UNKNOWN";

            return $result;
        }

    }