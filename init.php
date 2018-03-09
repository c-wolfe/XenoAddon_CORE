<?php

    namespace Cameron\XenoPanel\Addons\Core;

    require __DIR__ . '/classes/addon/Addon.class.php';

    use Cameron\XenoPanel\Addons\Core\Addon\AddonType;

    class AddonCore extends Addon {

        public function __construct() {
            parent::__construct("_core", "Cameron's Core", "1.0.0-DEV", ["Cameron Wolfe"], AddonType::HEADER);
        }

    }

    $Ccore = new AddonCore();
    $Ccore->initialize();