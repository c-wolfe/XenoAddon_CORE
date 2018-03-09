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