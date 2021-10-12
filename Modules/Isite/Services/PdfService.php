<?php


namespace Modules\Isite\Services;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\File;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class PdfService
{

  public function create($data)
  {
    $layout = 'isite::pdf.layouts.default';
    $themeLayout = 'pdf.layouts.default';

    if (view()->exists($themeLayout)) $layout = $themeLayout;

    if(isset($data["layout"]) && view()->exists($data["layout"]))  $layout = $data["layout"];

    $fileName = ($data['fileName'] ?? ('file'. '_' . strtotime(date("Y-m-d H:i:s")))) . '.pdf';

    //inserting an empty file into the disk route because the PDF package dont create the folders route necessary
    \Storage::disk($data["disk"] ?? 'exports')->put("test.txt", "test");
    \Log::info("pre pdfcreated");
    $pdf = \PDF::loadView($layout, ["data" => $data])->setPaper($data["paper"] ?? "letter")->save(Storage::disk($data["disk"] ?? 'exports')->path($fileName));
    \Log::info("post pdfcreated");
  }
}