<?php

namespace Modules\Idocs\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Modules\Idocs\Repositories\DocumentRepository;

class IdocsImport implements WithMultipleSheets, WithChunkReading, ShouldQueue
{
    private $documnet;

    private $info;

    public function __construct(DocumentRepository $documnet, $info)
    {
        $this->documnet = $documnet;
        $this->info = $info;
    }

    public function sheets(): array
    {
        return [
            'Documents' => new DocumentsImport($this->product, $this->info),
        ];
    }

    /*
    The most ideal situation (regarding time and memory consumption)
    you will find when combining batch inserts and chunk reading.
    */
    public function batchSize(): int
    {
        return 1000;
    }

    /*
     This will read the spreadsheet in chunks and keep the memory usage under control.
    */
    public function chunkSize(): int
    {
        return 1000;
    }
}
