<?php

    namespace Cameron\XenoPanel\Addons\Core\Addon;

    /**
     * Class AddonType
     *
     * @package Cameron\XenoPanel\Addons\Core\Addon
     */
    class AddonType {
        const __default = self::MANUAL;
        const HEADER = "header";
        const PAGE = "page";
        const FOOTER = "footer";
        const MANUAL = "manual";

        /**
         * @param $type AddonType
         *
         * @return string
         */
        public static function toString($type) {
            switch ($type) {
                case self::HEADER:
                    return "header";
                case self::PAGE:
                    return "page";
                case self::FOOTER:
                    return "footer";
                default:
                    return "manual";
            }
        }
    }