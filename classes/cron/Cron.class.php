<?php


    namespace Cameron\XenoPanel\Addons\Core\Cron;

    use Cameron\XenoPanel\Addons\Core\Addon;

    /**
     * Class Cron
     *
     * TODO: Waiting for documentation on APIv2 to implement this into a working version
     *
     * @package Cameron\XenoPanel\Addons\Core\Cron
     */
    class Cron {

        /** @var Addon */
        private $addon;

        public function __construct($addon) {
            $this->addon = $addon;
        }

    }
