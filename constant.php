<?php

$configs = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/configs.json");
$config = json_decode($configs, true);

