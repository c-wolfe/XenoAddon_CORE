<?php

    function str_starts_with($haystack, $needle) {
        return (substr($haystack, 0, strlen($needle)) === $needle);
    }

    function str_ends_with($haystack, $needle) {
        return strlen($needle) === 0 || (substr($haystack, -strlen($needle)) === $needle);
    }