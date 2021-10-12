<?php

namespace Modules\Media\Services;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Modules\Media\Entities\File;
use Modules\Media\Http\Requests\UploadMediaRequest;
use Modules\Media\Image\Imagy;
use Modules\Media\Jobs\CreateThumbnails;
use Modules\Media\Repositories\FileRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Validator;

class FileService
{
  use DispatchesJobs;
  
  /**
   * @var FileRepository
   */
  private $file;
  /**
   * @var Factory
   */
  private $filesystem;
  /**
   * @var Imagy
   */
  private $imagy;
  
  public function __construct(FileRepository $file, Factory $filesystem, Imagy $imagy)
  {
    $this->file = $file;
    $this->filesystem = $filesystem;
    $this->imagy = $imagy;
  }
  
  /**
   * @param UploadedFile $file
   * @param int $parentId
   * @param string $disk
   * @return mixed
   * @throws \Illuminate\Contracts\Filesystem\FileExistsException
   */
  public function store(UploadedFile $file, $parentId = 0, $disk = null, $createThumbnails = true)
  {
    $disk = is_null($disk) ? $this->getConfiguredFilesystem() : $disk;
    
    //validating avaiable extensions
    $request = new UploadMediaRequest(["file" => $file]);
    $validator = Validator::make($request->all(), $request->rules(), $request->messages());
    //if get errors, throw errors
    if ($validator->fails()) {
      $errors = json_decode($validator->errors());
      throw new \Exception(json_encode($errors), 400);
    }
    
    $savedFile = $this->file->createFromFile($file, $parentId, $disk);
    
    $this->resizeImages($file, $savedFile);
    
    $path = $this->getDestinationPath($savedFile->getRawOriginal('path'));
    $stream = fopen($file->getRealPath(), 'r+');
    
    //call Method delete for all exist in the disk with the same filename
    $this->imagy->deleteAllFor($savedFile);
    
    $this->filesystem->disk($disk)->writeStream($path, $stream, [
      'visibility' => 'public',
      'mimetype' => $savedFile->mimetype,
    ]);
    
    if ($createThumbnails)
      $this->createThumbnails($savedFile);
    
    return $savedFile;
  }
  
  /**
   * Resize Images based in the setting defaultImageSize
   * @param UploadedFile $file
   * @param $savedFile
   */
  private function resizeImages(UploadedFile $file, $savedFile)
  {
    if ($savedFile->isImage()) {
      
      $image = \Image::make(fopen($file->getRealPath(), 'r+'));
      
      $imageSize = json_decode(setting("media::defaultImageSize", null, config('asgard.media.config.defaultImageSize')));
      
      $image->resize($imageSize->width, $imageSize->height, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
      });
      
      //TODO:: aquí falta la lógica para la marca de agua según la entidad zone
      
      $filePath = $file->getPathName();
      \File::put($filePath, $image->stream($savedFile->extension, $imageSize->quality));
    }
  }
  
  /**
   * Create the necessary thumbnails for the given file
   * @param $savedFile
   */
  private function createThumbnails(File $savedFile)
  {
    $this->dispatch(new CreateThumbnails($savedFile->path, $savedFile->disk));
  }
  
  /**
   * @param string $path
   * @return string
   */
  private function getDestinationPath($path)
  {
    if ($this->getConfiguredFilesystem() === 'local') {
      return basename(public_path()) . $path;
    }
    
    return $path;
  }
  
  /**
   * @return string
   */
  private function getConfiguredFilesystem()
  {
    return setting('media::filesystem', null, config("asgard.media.config.filesystem"));
  }
}
