<?php

$composer = dirname(__DIR__) . '/vendor/autoload.php';

if (!file_exists($composer)) {
    die(
        "\n[ERROR] You need to run \"composer install\" before running the test suite.\n"
    );
}

require $composer;

\VCR\VCR::configure()->setCassettePath('fixtures');

\VCR\VCR::turnOn();

const API_KEY = 'StQNgqJETkBvyvLU-iiK';
