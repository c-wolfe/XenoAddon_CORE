<?php

    namespace Cameron\XenoPanel\Addons\Core\Time;

    /**
     * Class TimeUtil
     *
     * @package Cameron\XenoPanel\Addons\Core\Time
     */
    class TimeUtil {

        const MILLISECOND = 1;
        const SECOND = self::MILLISECOND * 1000;
        const MINUTE = self::SECOND * 60;
        const HOUR = self::MINUTE * 60;
        const DAY = self::HOUR * 24;
        const WEEK = self::DAY * 7;
        const MONTH = self::DAY * 30; // the "average" days in a month is 30.42, so round down to 30 days.
        const YEAR = self::MONTH * 12;
        const DECADE = self::YEAR * 10;
        const CENTURY = self::DECADE * 10;
        const __default = self::MILLISECOND;

        /**
         * @param $milliseconds   TimeUtil|int
         * @param $amount         int
         *
         * @return int
         */
        public static function toSecond($milliseconds, $amount) {
            return self::toMillisecond($milliseconds, $amount) / self::SECOND;
        }

        /**
         * @param $milliseconds   TimeUtil|int
         * @param $amount         int
         *
         * @return int
         */
        public static function toMillisecond($milliseconds, $amount) {
            return $milliseconds * $amount;
        }

        /**
         * @param $milliseconds   TimeUtil|int
         * @param $amount         int
         *
         * @return int
         */
        public static function toHour($milliseconds, $amount) {
            return self::toMillisecond($milliseconds, $amount) / self::HOUR;
        }

        /**
         * @param $milliseconds   TimeUtil|int
         * @param $amount         int
         *
         * @return int
         */
        public static function toDay($milliseconds, $amount) {
            return self::toMillisecond($milliseconds, $amount) / self::DAY;
        }

        /**
         * @param $milliseconds   TimeUtil|int
         * @param $amount         int
         *
         * @return int
         */
        public static function toWeek($milliseconds, $amount) {
            return self::toMillisecond($milliseconds, $amount) / self::WEEK;
        }

        /**
         * @param $milliseconds   TimeUtil|int
         * @param $amount         int
         *
         * @return int
         */
        public static function toMonth($milliseconds, $amount) {
            return self::toMillisecond($milliseconds, $amount) / self::MONTH;
        }

        /**
         * @param $milliseconds   TimeUtil|int
         * @param $amount         int
         *
         * @return int
         */
        public static function toYear($milliseconds, $amount) {
            return self::toMillisecond($milliseconds, $amount) / self::YEAR;
        }

        /**
         * @param $milliseconds   TimeUtil|int
         * @param $amount         int
         *
         * @return int
         */
        public static function toDecade($milliseconds, $amount) {
            return self::toMillisecond($milliseconds, $amount) / self::DECADE;
        }

        /**
         * @param $milliseconds   TimeUtil|int
         * @param $amount         int
         *
         * @return int
         */
        public static function toCentury($milliseconds, $amount) {
            return self::toMillisecond($milliseconds, $amount) / self::CENTURY;
        }

    }
