<?php


    namespace Cameron\XenoPanel\Addons\Core\Cron;

    use Cameron\XenoPanel\Addons\Core\Addon;

    /**
     * Class Cron
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
