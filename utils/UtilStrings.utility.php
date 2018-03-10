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

    function str_starts_with($haystack, $needle) {
        return (substr($haystack, 0, strlen($needle)) === $needle);
    }

    function str_ends_with($haystack, $needle) {
        return strlen($needle) === 0 || (substr($haystack, -strlen($needle)) === $needle);
    }

    function rand_str($length, $lowercase = true, $uppercase = true, $special = true, $numbers = true) {

        $string = "";

        $lc_chars = "abcdefghijklmnopqrstuvwxyz";
        $uc_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $nu_chars = "1234567890";
        $sp_chars = "!@#$%^&*()_+[]{}\|'\";:/?.>,<`~`'";

        $charset = explode('', ($lowercase ? $lc_chars : "") . ($uppercase ? $uc_chars : "") . ($special ? $sp_chars : "") . ($numbers ? $nu_chars : ""));

        for ($i = 0; $i < $length; $i++) {
            $string .= $charset[ random_int(0, sizeof($charset)) - 1 ];
        }

        return $string;
    }