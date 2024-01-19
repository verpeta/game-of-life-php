<?php

declare(strict_types=1);

namespace Vladislavverpeta\GameOfLifePhp\Service;

class GameService
{
    private array $grid;

    public function __construct(readonly private int $rows, readonly private int $cols)
    {
        $this->initializeGrid();
    }

    private function initializeGrid(): void
    {
        $this->grid = array_fill(0, $this->rows, array_fill(0, $this->cols, 0));

        // Initialize with glider in the center
        $centerRow = (int)($this->rows / 2);
        $centerCol = (int)($this->cols / 2);

        $this->grid[$centerRow - 1][$centerCol] = 1;
        $this->grid[$centerRow][$centerCol + 1] = 1;
        $this->grid[$centerRow + 1][$centerCol - 1] = $this->grid[$centerRow + 1][$centerCol] = $this->grid[$centerRow + 1][$centerCol + 1] = 1;
    }

    public function printGrid(): void
    {
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                echo ($this->grid[$i][$j] === 1) ? 'X' : '-';
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    public function updateGrid(): void
    {
        $newGrid = $this->grid;

        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $neighbors = $this->countLiveNeighbors($i, $j);

                if ($this->grid[$i][$j] === 1) {
                    if ($neighbors < 2 || $neighbors > 3) {
                        $newGrid[$i][$j] = 0;
                    }
                } elseif ($neighbors === 3) {
                    $newGrid[$i][$j] = 1;
                }
            }
        }

        $this->grid = $newGrid;
    }

    private function countLiveNeighbors(int $row, int $col): int
    {
        $count = 0;

        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                $neighborRow = $row + $i;
                $neighborCol = $col + $j;

                if ($neighborRow >= 0 && $neighborRow < $this->rows && $neighborCol >= 0 && $neighborCol < $this->cols && !($i === 0 && $j === 0)) {
                    $count += $this->grid[$neighborRow][$neighborCol];
                }
            }
        }

        return $count;
    }
}