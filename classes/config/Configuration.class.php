<?php

    namespace Cameron\XenoPanel\Addons\Core\Configuration;

    use Cameron\XenoPanel\Addons\Core\Addon;

    /**
     * Class Configuration
     *
     * @package Cameron\XenoPanel\Addons\Core\Configuration
     */
    class Configuration {

        /** @var Addon */
        private $addon;
        private $database;
        /** @var array */
        private $config;
        /** @var array */
        private $default_config;

        public function __construct($addon) {
            $this->addon = $addon;
            $this->database = $GLOBALS['database'];
        }

        /**
         * Save the default configuration information for the plugin. Set it using $this->setDefaultConfiguration([])
         */
        public function saveDefaultConfig() {

            foreach (array_keys($this->getDefaultConfig()) as $key) {
                $this->setConfig($key, $this->default_config[ $key ]);
            }

            $this->saveConfig();
        }

        /**
         * @return array
         */
        public function getDefaultConfig() {
            return $this->default_config;
        }

        /**
         * @param array $default_config
         */
        public function setDefaultConfig($default_config) {
            $this->default_config = $default_config;
        }

        /**
         * Save all configuration options to the database
         */
        public function saveConfig() {

            foreach (array_keys($this->config) as $key) {

                $key = strtolower($this->addon->getName() . "_" . $key);
                $val = $this->config[ $key ];

                if (!$this->addon->rowExistsInDatabase('addons_configuration', ['name'], [$key])) {
                    $this->database->insert("addons_configuration", [
                        "addon"         => $this->addon->getName(),
                        "name"          => $key,
                        "value"         => $val['value'],
                        "long_name"     => $val['long_name'],
                        "long_details"  => $val['long_details'],
                        "preg_replace"  => $val['preg_replace'],
                        "extra"         => $val['extra'],
                        "extra_details" => $val['extra_details'],
                    ]);
                } else {
                    $this->database->update("addons_configuration", [
                        "value"         => $val['value'],
                        "long_name"     => $val['long_name'],
                        "long_details"  => $val['long_details'],
                        "preg_replace"  => $val['preg_replace'],
                        "extra"         => $val['extra'],
                        "extra_details" => $val['extra_details'],
                    ], [
                        "addon" => $this->addon->getName(),
                        "name"  => $key,
                    ]);
                };

            }

        }

        /**
         * Load your configuration options from the database
         */
        public function loadConfig() {

            $result = $this->database->select("addons_configuration", "addon", [
                "addon" => $this->addon->getName()
            ]);

            foreach ($result as $item) {
                $item['name'] = str_replace($this->addon->getName(), '', $item['name'], $count = 1);
                $this->setConfig($item['name'], $item);
            }

        }

        /**
         * @param      $name         string Name of the option
         * @param      $value        string Value of the option
         * @param      $long_name    string Display [long] name of the option
         * @param null $long_details string Details [description] of the option.
         * @param null $preg_replace string []
         * @param null $extra        string Extra details for the option
         *
         * Create a configuration option
         */
        public function createConfigOption($name, $value, $long_name, $long_details = null, $preg_replace = null, $extra = null) {
            $val = [];
            $val['name'] = $name;
            $val['value'] = $value;
            $val['long_name'] = $long_name;
            $val['long_details'] = $long_details;
            $val['preg_replace'] = $preg_replace;
            $val['extra'] = $extra;
            $this->setConfig($name, $val, true);
        }

        /**
         * @param      $key   string Name of the option to update
         * @param      $value string Value to update to
         * @param bool $save  Automatically save the config to the database [not recommended unless you plan on ONLY
         *                    updating this ONE value]
         *
         * Set the direct value of a variable
         */
        public function setConfigOption($key, $value, $save = false) {
            if ($this->config == null) {
                $this->config = [];
            }
            $this->config[ $key ]['value'] = $value;
            if ($save) {
                $this->saveConfig();
            }
        }

        /**
         * @param null $key String key to get. If null, returns our entire config object
         *
         * @return array Config option of the key
         */
        public function getConfig($key = null) {
            return ($key == null ? $this->config : $this->config[ $key ]);
        }

        /**
         * @param      $key   string Name of the option to update
         * @param      $value array Value to update to
         * @param bool $save  Automatically save the config to the database [not recommended unless you plan on ONLY
         *                    updating this ONE value]
         *
         * Set the value of a variable
         */
        public function setConfig($key, $value, $save = false) {
            if ($this->config == null) {
                $this->config = [];
            }
            $this->config[ $key ] = $value;
            if ($save) {
                $this->saveConfig();
            }
        }

        /**
         * @param $key string Key to get the value for
         *
         * @return string Get the direct value of an option
         */
        public function getOption($key) {
            return $this->config[ $key ]['value'];
        }


    }