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

    if (!isset($_addon_name) || empty($_addon_name)) {
        header("Location: /_core");
        die('Empty `ADDON` variable.');
    }

    if ($_addon_name == $Ccore->getName()) {
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

    echo "<h4>{$_addon->getTitle()} <b>v</b>{$_addon->getVersion()} <b>by</b> {$_addon->getAuthor()}</h4>";

    if (isset($_POST['do_install'])) {

        echo "Initializing...<br>";
        $_addon->initialize();
        echo "Installing...<br>";
        $_addon->install();

        $error = $_addon->database->error();

        switch ($error[0]) {

            case '00000': {
                echo "Successfully installed {$_addon->getTitle()}! Click <a href='/admin/addons'>here</a> to enable it.";
                break;
            }

            case '23000': {
                echo "<br><br>Failed! <br>An addon with the one you're trying to install, already exists in the database. Please verify that your `addons_list` table in your database, does not have a row with the following values, name:`{$_addon->getName()}`,short:`{$_addon->getTitle()}`. If you do, please manually review your plugins installed, and see if you're eligible to manually delete the row. If yes, then attempt to install the addon again. If no, please contact a developer to assist you.`";
                break;
            }

            default: {
                echo 'Failed! <br>An unhandled exception has occurred. We have collected this data, and we\'re gonna get this fixed for ya!';
                break;
            }

        }

    } else {

        ?>


        <p>


        <?php


        if ($Ccore->rowExistsInDatabase('addons_list', ['name'], [$_addon->getTitle()])) {
            echo "It seems that you already have an addon installed with the name of {$_addon->getTitle()}. You should manually review this before attempting to install the addon.";
        } elseif ($Ccore->rowExistsInDatabase('addons_list', ['short'], [$_addon->getName()])) {
            echo "It seems that you already have an addon installed with the alias of {$_addon->getName()}. You should manually review this before attempting to install the addon.";
        } else { ?>
            You are about to install <?= $_addon->getTitle() ?> v<?= $_addon->getVersion() ?>. Are you
            <b>sure</b> you want to install this addon?

            <form method="post">

                <input name="do_install" value="yes" type="hidden">
                <button type="submit" class="btn btn-success">Yes!</button>
                <a href="javascript:history.go(-1)" class="btn btn-danger">No!</a>

            </form>
        <?php } ?>

        </p>
    <?php } ?>