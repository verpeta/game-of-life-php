<?php

declare(strict_types=1);
require 'vendor/autoload.php';

use Vladislavverpeta\GameOfLifePhp\Service\GameService;

// Example usage with a 25x25 grid:
$rows = 25;
$cols = 25;

$gameOfLife = new GameService($rows, $cols);

for ($generation = 0; $generation < 48; $generation++) {
    echo "Generation {$generation}:" . PHP_EOL;
    $gameOfLife->printGrid();
    $gameOfLife->updateGrid();
}