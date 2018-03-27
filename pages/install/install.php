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

    $Ccore->initialize();

    if (isset($_POST['do_install'])) {

        echo 'Doing main XenoPanel install...';

        $Ccore->install();

        echo 'Completed XenoPanel install. Fetching SQL scripts...<br>';

        $files = scandir($Ccore->getDirectory() . 'pages/install/sql');
        $files = array_diff_key($files, [
            '.',
            '..'
        ]);

        echo 'Got SQL scripts. Executing them...<br>';

        foreach ($files as $file) {
            $contents = file_get_contents("{$Ccore->getDirectory()}pages/install/sql/$file");
            $database->query($contents);
        }

        echo 'Executed SQL scripts. Deleting them from flatfile...<br>';

        foreach ($files as $file) {
            unlink("{$Ccore->getDirectory()}pages/install/sql/$file");
        }
        rmdir("{$Ccore->getDirectory()}pages/install/sql");
        
        echo "Install finished! Click <a href='#' target='_blank'>here</a> to visit the marketplace to search for addons that use {$Ccore->getTitle()}!";

    } else { ?>

        <link rel="stylesheet" href="<?php echo $template_url ?>/assets/examples/css/pages/errors.min.css">

        <div class="page-error page-error-404 offset-sm-3 col-sm-6 col-xs-12 text-center">
            <header>
                <h3 class="animation-slide-top">Are you sure you want to install <?= $Ccore->getTitle() ?>?</h3>
                <p>If you are installing this addon from GitHub, PLEASE DO NOT! Visit the marketplace
                    <a href="#" target="_blank">here</a> and download the CORRECT version of the addon, which has been approved for production use.


                    <i> <br><br><br><br>
                        <b>Disclosure:</b> There is no warranty with this addon, we cannot guarantee continuous updates to this addon, nor to addons that utilize it.
                    </i>
                </p>
            </header>

            <form method="post">
                <input name="do_install" value="1" type="hidden">
                <button type="submit" class="btn btn-primary btn-round">YES, PLEASE!</button>
            </form>

        </div>
    <?php } ?>

