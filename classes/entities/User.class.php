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


    class CUser {

        private static $api;
        /** @var  array */
        private static $user;
        /** @var  string */
        private $username;

        public function __construct($user = null) {
            self::$api = $GLOBALS['User'];
            self::$user = $user;
            $this->username = $user['username'];
        }

        /**
         * @param int $name
         *
         * @return CUser|null
         */
        public static function fromName($name) {
            $api = $GLOBALS['User'];
            $result = $api->user($name);
            if ($result instanceof \SplBool && !$result) {
                return null;
            }
            self::$api = $api;

            $user = new CUser($result);
            $user->username = $name;

            return $user;
        }

        /**
         * Gets the email address of the username provided.
         *
         * @return string
         */
        public function getEmailAddress() {
            $result = self::$api->get_email_address($this->joining());

            return ($result instanceof \SplBool && !$result) ? "" : $result;
        }

        private function joining($array = []) {
            return array_merge(['username' => $this->getUsername()], $array);
        }

        /**
         * @return string
         */
        public function getUsername() {
            return $this->username;
        }

        /**
         * Sets the email address of the username provided.
         *
         * @param string $address
         */
        public function setEmailAddress($address) {
            self::$api->set_email_address($this->joining(), $address);
        }

        /**
         * Check if a user is currently banned.
         *
         * @return boolean
         */
        public function isBanned() {
            return self::$api->is_banned($this->joining());
        }

        /**
         * Sets the user to banned true.
         */
        public function ban() {
            self::$api->banned($this->joining());
        }

        /**
         * Sets the user to banned false.
         */
        public function unban() {
            self::$api->unbanned($this->joining());
        }

    }