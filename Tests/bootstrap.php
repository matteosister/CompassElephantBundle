<?php
/**
 * Created by JetBrains PhpStorm.
 * User: matteo
 * Date: 01/02/12
 * Time: 12.47
 *
 * Just for fun...
 */
 

if (file_exists($file = __DIR__.'/autoload.php')) {
    require_once $file;
} elseif (file_exists($file = __DIR__.'/autoload.php.dist')) {
    require_once $file;
}