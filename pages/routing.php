<?php
    /**
     * Copyright 2018 Cameron Wolfe
     *
     * Licensed under the Apache License, Version 2.0 (the "License");
     * you may not use this file except in compliance with the License.
     * You may obtain a copy of the License at
     *
     * http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software
     * distributed under the License is distributed on an "AS IS" BASIS,
     * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     * See the License for the specific language governing permissions and
     * limitations under the License.
     */

    if ($Ccore->isVersionDev()) {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }

    if (!defined('XenoPanel')) die('Direct access not permitted');

    // Everything in this addon is for admins and developers, so let's make our lives easier and put the check here.
    if ($role !== 'admin') {
        setcookie('_core:error', -99);
        header("Location: /");
        die('No permission. Requires: `ADMIN`');
    }

    $uri = str_replace('/c', '', str_replace('/core', '', $_SERVER['REQUEST_URI']));

    if (str_starts_with($uri, '/install/')) {
        $_addon_name = str_replace('/install/', '', $uri);
        include 'install-addon.php';
    }//

    elseif (str_starts_with($uri, '/install')) {
        if ($Ccore->rowExistsInDatabase('addons_list', ['short'], [$Ccore->getName()])) {
            header("Location: $url/c/upgrade");
            exit;
        }
        include 'install/install.php';
    }//

    elseif (str_starts_with($uri, '/upgrade')) {
        include 'upgrade.php';
    }//

    else {
        include 'home.php';
    }


