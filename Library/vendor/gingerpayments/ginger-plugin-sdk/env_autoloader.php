<?php
$env = fopen(__DIR__."/.env", "r");
$content = fread($env, filesize(__DIR__.'/.env'));
fclose($env);
$content = explode("\n", $content);
foreach ($content as $line) {
    $line_exploded = explode("=", $line);
    $_ENV[$line_exploded[0]] = $line_exploded[1];
}