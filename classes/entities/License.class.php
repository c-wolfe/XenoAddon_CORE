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

        private static $License;

        /** @var  boolean */
        private static $valid = false;
        /** @var  boolean */
        private static $free = true;
        /** @var boolean */
        private static $unlimited = true;
        /** @var  boolean */
        private static $unlimited_servers = false;
        /** @var  boolean */
        private static $unlimited_nodes = true;
        /** @var  string */
        private static $license_response = null;
        /** @var  int */
        private static $allowed_node_count;

        public function __construct() {
            self::$License = $GLOBALS['License'];
        }

        /**
         * @return bool
         */
        public static function isValid() {
            if (!self::$valid) {
                self::$valid = self::$License->has_valid_license();
            }

            return self::$valid;
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
            if (self::$free) {
                self::$free = self::$License->is_free_license();
            }

            return self::$free;
        }

        /**
         * @return bool
         */
        public static function isUnlimited() {
            if (self::$unlimited) {
                self::$unlimited = self::$License->is_unlimited_licenses();
            }

            return self::$unlimited;
        }

        /**
         * @return bool
         */
        public static function isUnlimitedServers() {
            if (self::$unlimited_servers) {
                self::$unlimited_servers = self::$License->get_allowed_server_count() == 999999;
            }

            return self::$unlimited_servers;
        }

        /**
         * @return bool
         */
        public static function isUnlimitedNodes() {
            if (self::$unlimited_nodes) {
                self::$unlimited_nodes = self::getAllowedNodeCount() == 999999;
            }

            return self::$unlimited_nodes;
        }

        /**
         * @return int
         */
        public static function getAllowedNodeCount() {
            if (self::$allowed_node_count) {
                self::$allowed_node_count = self::$License->get_allowed_node_count();
            }

            return self::$allowed_node_count;
        }

        /**
         * @return string
         */
        public static function getLicenseResponse() {
            if (self::$license_response == null) {
                self::$license_response = self::$License->get_license_response();
            }

            return self::$license_response;
        }

    }