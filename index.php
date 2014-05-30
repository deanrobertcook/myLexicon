<?php
/*
 * Blank index.php file for a new website/app
 * There are also blank template folders to avoid having to refind all of these basic parts to an app.
 */
require_once 'core/init.php';
$router = new Router();
$router->runController();
