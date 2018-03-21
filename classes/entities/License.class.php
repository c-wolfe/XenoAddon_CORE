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

    $Clicense = new CLicense();

    /**
     * Class CLicense
     *
     * Can't even use reserved class names, even if they're in their own namespace -_-
     *
     * @package Cameron\XenoPanel\Addons\Core\Entities
     */
    class CLicense {

        private static $api;

        public function __construct() {
            self::$api = $GLOBALS['License'];
        }

        /**
         * @return bool
         */
        public static function isValid() {
            return self::$api->has_valid_license();
        }

        /**
         * @return bool
         */
        public static function isPaid() {
            return !self::isFree();
        }

        /**
         * @return bool
         */
        public static function isFree() {
            return self::$api->is_free_license();
        }

        /**
         * @return bool
         */
        public static function isUnlimited() {
            return self::$unlimited = self::$api->is_unlimited_licenses();
        }

        /**
         * @return bool
         */
        public static function isUnlimitedServers() {
            return self::$unlimited_servers = self::$api->get_allowed_server_count();
        }

        /**
         * @return bool
         */
        public static function isUnlimitedNodes() {
            return self::$unlimited_nodes = self::getAllowedNodeCount();
        }

        /**
         * @return int
         */
        public static function getAllowedNodeCount() {
            return self::$allowed_node_count = self::$api->get_allowed_node_count();
        }

        /**
         * @return string
         */
        public static function getLicenseResponse() {
            return self::$license_response = self::$api->get_license_response();
        }

    }