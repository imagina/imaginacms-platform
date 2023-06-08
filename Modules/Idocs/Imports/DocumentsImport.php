<?php

namespace Modules\Idocs\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Idocs\Repositories\DocumentRepository;

class DocumentsImport implements ToCollection, WithChunkReading, WithHeadingRow, ShouldQueue
{

    private $document;
    private $info;

    public function __construct(
        DocumentRepository $documnet,
        $info
    )
    {
        $this->info = $info;
        $this->document = $documnet;
    }

    /**
     * Data from Excel
     */
    public function collection(Collection $rows)
    {
        $locale=$this->info['Locale'];
        $rows = json_decode(json_encode($rows));
        foreach ($rows as $row) {
            try {
                if (isset($row->id)) {
                    $documnet_id = (int)$row->id;
                    $title = (string)$row->title;
                    $description = (string)$row->description;
                    $category_id = (int)$row->category_id;
                    $user_identification = (int)$row->user_identification;
                    $file=(int)$row->file;
                    $status = $row->status;
                    $categories=explode(',', $row->categoires);
                    $document = $this->document->find($documnet_id);
                    $param = [
                        'id' => $documnet_id,
                        $locale =>[
                            'title'=>$title,
                            'description' => $description,
                        ] ,
                        'user-identification' => $user_identification,
                        'medias_single'=>[
                            'file'=>$file
                        ],
                        'category_id' => $category_id,
                        'categories'=>$categories,
                        'status'=>$status,


                    ];
                    if ($document) {
                        //Update
                        $this->document->update($document, $param);
                        \Log::info('Update Product: ' . $document->id . ', Title: ' . $document->title);
                    } else {
                        //Create
                        $newDocument = $this->documnet->create($param);

                        \Log::info('Create a Product: ' . $newDocument->title);
                    }
                }//if row!=name
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
                \Log::error($e->getLine());
                // dd($e->getMessage());
            }

        }// foreach

    }//collection rows

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
