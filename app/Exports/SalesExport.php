<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SalesExport implements Export, WithMultipleSheets
{
    public function __construct(protected $start, protected $end, protected $kasirId = null) {}

    public function sheets(): array
    {
        return [
            new SalesSheet($this->start, $this->end, $this->kasirId),
            new TopProductsSheet($this->start, $this->end, $this->kasirId),
        ];
    }
}