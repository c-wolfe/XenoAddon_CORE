<?php
    /**
     *    Copyright 2018 Cameron Wolfe
     *
     *    Licensed under the Apache License, Version 2.0 (the "License");
     *    you may not use this file except in compliance with the License.
     *    You may obtain a copy of the License at
     *
     *        http://www.apache.org/licenses/LICENSE-2.0
     *
     *    Unless required by applicable law or agreed to in writing, software
     *    distributed under the License is distributed on an "AS IS" BASIS,
     *    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     *    See the License for the specific language governing permissions and
     *    limitations under the License.
     */

    namespace Cameron\XenoPanel\Addons\Core;

    use Cameron\XenoPanel\Addons\Core\Addon\AddonType;
    use Cameron\XenoPanel\Addons\Core\Configuration\Configuration;
    use Cameron\XenoPanel\Addons\Core\Routing\Routing;

    /**
     * Class Addon
     *
     * @package Cameron\XenoPanel\Addons\Core
     */
    abstract class Addon {

        public $api;
        public $database;

        /** @var string */
        private $name;
        /** @var String */
        private $title;
        /** @var string */
        private $version;
        /** @var AddonType */
        private $type;
        /** @var array */
        private $authors;
        /** @var Configuration */
        private $config;
        /** @var Routing */
        private $routing;
        /** @var bool */
        private $premium;
        /** @var string */
        private $license = null;

        public function __construct($name, $title, $version, $authors, $type, $premium = false) {
            $this->api = $GLOBALS['apiv2'];
            $this->database = $GLOBALS['database'];
            $this->name = $name;
            $this->title = $title;
            $this->version = $version;
            $this->authors = $authors;
            $this->type = $type;
            $this->premium = $premium;

            if (!$this->rowExistsInDatabase('addons_list', ['short'], [$this->getName()])) {

                $this->database->insert('addons_list', [
                    "enabled" => false,
                    "name"    => $this->getTitle(),
                    "short"   => $this->getName(),
                    "version" => $this->getVersion()
                ]);

            } else {
                $this->database->update('addons_list', ['version' => $this->getVersion()], ['short' => $this->getName()]);
            }

            if ($this->isPremium()) {
                if (file_exists($this->getDirectory() . '/.license')) {
                    $this->setLicense(file_get_contents($this->getDirectory() . '/.license'));
                }
            }

        }

        /**
         * @param $table  string Table to check
         * @param $column array The column(s) to check for
         * @param $value  array
         *
         * @return bool
         */
        public function rowExistsInDatabase($table, $column, $value) {
            $search = [];
            for ($i = 0; $i < sizeof($column); $i++) {
                $search[ $column[ $i ] ] = $value[ $i ];
            }

            return isset($this->database->select($table, $column, $search)[0]);
        }

        /**
         * @return string
         */
        public function getName() {
            return strtolower($this->name);
        }

        /**
         * @return String
         */
        public function getTitle() {
            return $this->title;
        }

        /**
         * @return string
         */
        public function getVersion() {
            return strtoupper($this->version);
        }

        /**
         * @param string $version
         */
        public function setVersion($version) {
            $this->version = $version;
            $this->database->update('addons_list', ['version' => $this->getVersion()], ['short' => $this->getName()]);
        }

        /**
         * Check whether the addon is a premium plugin or not.
         *
         * @return bool
         */
        public function isPremium() {
            return $this->premium;
        }

        /**
         * @param bool $premium
         */
        public function setPremium($premium) {
            $this->premium = $premium;
        }

        /**
         * Get the directory of the addon
         *
         * @return string
         */
        public function getDirectory() {
            return __DIR__;
        }

        /**
         * Initialize the addon
         */
        public function initialize() {
            if ($this->onLoad()) $this->onEnable();
        }

        /**
         * @return bool Whether we loaded successfully
         */
        public function onLoad() {
            $GLOBALS['config'] = $this->getAddonConfig();

            $this->config = new Configuration($this);
            $this->getConfig()
                ->saveDefaultConfig();

            $this->routing = new Routing($this);
            $this->getRouting()
                ->saveDefaultRoutes();

            return true;
        }

        /**
         * Get the config required for XenoPanel to load the addon
         *
         * @return array
         */
        public function getAddonConfig() {
            $config = [];
            $config['name'] = $this->getName();
            $config['title'] = $this->getTitle();
            $config['version'] = $this->getVersion();
            $config['authors'] = $this->getAuthors();
            $config['type'] = AddonType::toString($this->getType());
            if ($this->getLicense() != null) $config['license'] = $this->getLicense();

            return $config;
        }

        /**
         * @return array
         */
        public function getAuthors() {
            return $this->authors;
        }

        /**
         * @return AddonType
         */
        public function getType() {
            return $this->type;
        }

        /**
         * @return string
         */
        public function getLicense() {
            return $this->license;
        }

        /**
         * @param string $license
         */
        public function setLicense($license) {
            $this->license = $license;
        }

        /**
         * @return Configuration
         */
        public function getConfig() {
            return $this->config;
        }

        /**
         * @return Routing
         */
        public function getRouting() {
            return $this->routing;
        }

        /**
         * @return bool Whether we enabled successfully
         */
        public function onEnable() { return true; }

        /**
         * @return string Get formatted author list
         */
        public function getAuthor() {
            $author = "";
            foreach ($this->getAuthors() as $_author) {
                $author .= ", " . $_author;
            }

            return substr($author, strlen(", "));
        }

        /**
         * @return bool Development version
         */
        public function isVersionDev() {
            return str_ends_with($this->getVersion(), '-DEV') || str_ends_with($this->getVersion(), '-DEVELOPMENT');
        }

        /**
         * @return bool Snapshot version
         */
        public function isVersionSnapshot() {
            return str_ends_with($this->getVersion(), '-SNAPSHOT');
        }

        /**
         * @return bool Alpha version
         */
        public function isVersionAlpha() {
            return str_ends_with($this->getVersion(), '-ALPHA');
        }

        /**
         * @return bool Beta version
         */
        public function isVersionBeta() {
            return str_ends_with($this->getVersion(), '-BETA');
        }

        /**
         * @return bool Release version
         */
        public function isVersionRelease() {
            return str_ends_with($this->getVersion(), '-RELEASE');
        }

        //TODO: Implement logging functions once documentation has been released for APIv2

        /**
         * Log debug information to the addons logging file.
         *
         * @param $debug string Debug to log
         */
        public function debug($debug) { }

        /**
         * Log information to the addons logging file.
         *
         * @param $info string Information to log
         */
        public function info($info) { }

        /**
         * Log a warning to the addons logging file.
         *
         * @param $warn string warn to log
         */
        public function warn($warn) { }

        /**
         * Log an error to the addons logging file.
         *
         * @param $error string Error to log
         */
        public function error($error) { }


    }