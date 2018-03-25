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

    error_reporting(E_ALL);
    ini_set("display_errors", 1);


    if (!isset($_GET['addon']) || empty($_GET['addon'])) {
        header("Location: /_core");
        die('Empty `ADDON` variable.');
    }

    require __DIR__ . '/../init.php';
    $config = $Ccore->getAddonConfig([
        'title'    => 'Install Addon',
        'location' => 'page',
    ]);

    if ($_GET['addon'] == $Ccore->getName()) {
        setcookie('_core:error', 1);
        header("Location: /{$Ccore->getName()}");
        die('Cannot install self');
    }

    $path = $Ccore->getRootDirectory() . "addons/$_GET[addon]/init.php";

    if (!file_exists($path)) {
        setcookie('_core:error', 2);
        header("Location: /{$Ccore->getName()}");
        die('Requested addon\'s path does not exist');
    }

    if (!(include $path)) {
        setcookie('_core:error', 3);
        header("Location: /{$Ccore->getName()}");
        die('Failed to import file');
    }

    require __DIR__ . '/../../../includes/init.php';

    if ($role !== 'admin') {
        setcookie('_core:error', -99);
        header("Location: /{$Ccore->getName()}");
        die('No permission. Requires: `ADMIN`');
    }

    $Ccore->initialize();

    //test
    echo $_addon->getTitle() . ' v' . $_addon->getVersion() . ' by ' . $_addon->getAuthor();
    //end test

    //...