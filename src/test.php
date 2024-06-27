<?php
$path = __DIR__ . '/var/fire_base_config.json';
echo $path;
if (file_exists($path) && is_readable($path)) {
    echo "File is readable\n";
} else {
    echo "File is not readable\n";
}