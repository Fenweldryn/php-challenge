<?php

namespace App\Helpers;

use App\Models\Stock;

class StockRequestHelper {
    private string $stockData;
    private ?Stock $parsedStockData = null;
    private bool $isDataValid = false;

    public function __construct(string $stockResponse)
    {
        $this->stockData = $stockResponse;
        $this->parseJsonStockData();
    }

    public function parseJsonStockData(): void
    {
        try {
            $symbol = json_decode($this->stockData)->symbols['0'];
            $this->parsedStockData = new Stock([
                'name' => $symbol->symbol,
                'symbol' => $symbol->symbol,
                'open' => $symbol->open,
                'high' => $symbol->high,
                'low' => $symbol->low,
                'close' => $symbol->close
            ]);
            $this->isDataValid = true;

        } catch (\Throwable $th) {

        }
    }

    public function parseRawStockData(): void
    {
        $lines = explode(',', $this->stockData);

        if ($lines[count($lines) - 1] == "\r\n") {
            array_pop($lines);
        }

        if (in_array('N/D', $lines)) {
            return;
        }

        try {
            $this->parsedStockData = new Stock([
                'name' => $lines[0],
                'symbol' => $lines[1],
                'open' => $lines[2],
                'high' => $lines[3],
                'low' => $lines[4],
                'close' => $lines[5],
            ]);
            $this->isDataValid = true;

        } catch (\Throwable $th) {

        }
    }

    public function isDataValid(): bool
    {
        return $this->isDataValid;
    }

    public function getStockData(): ?Stock {
        return $this->parsedStockData;
    }
}